from typing import Annotated, TypedDict
from langchain_google_genai import ChatGoogleGenerativeAI
from langgraph.graph import StateGraph, START, END
from langgraph.graph.message import add_messages
from langchain_core.messages import HumanMessage, AIMessage, SystemMessage
from app.core.config import settings
from app.core.prompts import CONSULTATION_SYSTEM_PROMPT
from app.db import async_session_maker
from app.models.chat_message import ChatMessage
from sqlalchemy import select

REPORT_READY_SIGNAL = "Ya tengo suficiente información sobre tu negocio."
MAX_CONSULTATION_TURNS = 10  # Max messages before forcing conclusion

# State for the LangGraph
class ConsultationState(TypedDict):
    messages: Annotated[list, add_messages]


class ConsultationService:
    def __init__(self):
        self.llms = [
            ChatGoogleGenerativeAI(
                model="gemini-2.5-flash-lite",
                google_api_key=key,
                temperature=0.5  # Slightly lower temp for focused information gathering
            ) for key in settings.gemini_api_keys_list
        ]
        if not self.llms:
            print("WARNING: [ConsultationService] No Gemini API keys found.")
        else:
            print(f"INFO: [ConsultationService] Loaded {len(self.llms)} Gemini API keys.")

        self._current_llm_index = 0
        self.workflow = self._create_workflow()
        self.app = self.workflow.compile()

    def _get_llm(self):
        if not self.llms:
            raise ValueError("No Gemini API keys configured.")
        llm = self.llms[self._current_llm_index]
        self._current_llm_index = (self._current_llm_index + 1) % len(self.llms)
        return llm

    def _create_workflow(self):
        workflow = StateGraph(ConsultationState)

        async def call_model(state: ConsultationState):
            # Always inject the consultation system prompt
            messages = [SystemMessage(content=CONSULTATION_SYSTEM_PROMPT)] + state["messages"]
            llm = self._get_llm()
            response = await llm.ainvoke(messages)
            return {"messages": [response]}

        workflow.add_node("consultant", call_model)
        workflow.add_edge(START, "consultant")
        workflow.add_edge("consultant", END)

        return workflow

    async def get_history(self, session_id: str):
        """Load stored messages for this consultation session."""
        async with async_session_maker() as session:
            result = await session.execute(
                select(ChatMessage)
                .where(ChatMessage.thread_id == f"consultation_{session_id}")
                .order_by(ChatMessage.created_at.asc())
            )
            messages = result.scalars().all()
            output = []
            for m in messages:
                if m.role == "user":
                    output.append(HumanMessage(content=m.content))
                else:
                    output.append(AIMessage(content=m.content))
            return output

    async def get_session_history(self, session_id: str):
        """Returns history in a serializable format for the frontend."""
        history = await self.get_history(session_id)
        return [
            {"role": "user" if isinstance(m, HumanMessage) else "bot", "content": m.content}
            for m in history
        ]

    async def save_message(self, session_id: str, role: str, content: str):
        """Persist a message with a 'consultation_' prefixed thread_id to avoid collisions."""
        async with async_session_maker() as session:
            message = ChatMessage(
                thread_id=f"consultation_{session_id}",
                role=role,
                content=content
            )
            session.add(message)
            await session.commit()

    async def count_turns(self, session_id: str) -> int:
        """Count how many AI messages have been sent in this session."""
        history = await self.get_history(session_id)
        return sum(1 for m in history if isinstance(m, AIMessage))

    async def get_response(self, message: str, session_id: str) -> dict:
        """Process the user message and return response plus a flag if info is complete."""
        history = await self.get_history(session_id)
        await self.save_message(session_id, "user", message)

        # If we've hit the max turns, instruct the model to wrap up
        turns = await self.count_turns(session_id)
        
        input_messages = history + [HumanMessage(content=message)]

        result = await self.app.ainvoke({"messages": input_messages})
        response_text = result["messages"][-1].content

        await self.save_message(session_id, "model", response_text)

        # Detect if the model signaled completion
        report_ready = REPORT_READY_SIGNAL in response_text

        return {
            "response": response_text,
            "report_ready": report_ready,
            "turn": turns + 1,
        }

    async def generate_report(self, session_id: str) -> dict:
        """Generate a structured business needs report from the consultation history."""
        import json, re

        history = await self.get_history(session_id)

        if not history:
            return {"error": "No hay suficiente información para generar un informe."}

        # Build a full conversation transcript
        transcript_lines = []
        for m in history:
            if isinstance(m, HumanMessage):
                transcript_lines.append(f"Usuario: {m.content}")
            elif isinstance(m, AIMessage):
                transcript_lines.append(f"Consultor: {m.content}")
        transcript = "\n".join(transcript_lines)

        report_prompt = f"""
Eres un analista de negocios senior de Maquina Virtual SPA. Basándote en la conversación de consulta, genera un informe estructurado en formato JSON estricto.

CONVERSACIÓN:
{transcript}

Responde ÚNICAMENTE con un objeto JSON válido (sin texto antes ni después, sin markdown, sin bloques de código). El objeto debe tener exactamente estos campos:

{{
  "empresa": {{
    "nombre": "...",
    "rubro": "...",
    "tamano": "...",
    "antiguedad": "..."
  }},
  "situacion_actual": "Descripción objetiva y concisa de la situación actual del negocio.",
  "necesidad_principal": "La necesidad o problema más importante que quieren resolver.",
  "desafios": ["Desafío 1", "Desafío 2", "Desafío 3"],
  "oportunidades": [
    {{"titulo": "Área de Oportunidad 1", "descripcion": "..."}},
    {{"titulo": "Área de Oportunidad 2", "descripcion": "..."}},
    {{"titulo": "Área de Oportunidad 3", "descripcion": "..."}}
  ],
  "soluciones_mv": "Párrafo explicando cómo Maquina Virtual SPA puede ayudar específicamente a este cliente. Menciona experiencia en software a medida, agentes de IA y automatización. Invita a una consultoría técnica gratuita.",
  "proximos_pasos": ["Paso concreto 1", "Paso concreto 2", "Paso concreto 3"]
}}

El tono debe ser profesional, inspirador y de confianza. Sé conciso, ve al grano y al dolor del cliente.
"""

        llm = self._get_llm()
        report_result = await llm.ainvoke([HumanMessage(content=report_prompt)])
        raw = report_result.content.strip()

        # Strip markdown code fences if the model adds them
        raw = re.sub(r"^```(?:json)?\s*", "", raw)
        raw = re.sub(r"\s*```$", "", raw.strip())

        try:
            return json.loads(raw)
        except (json.JSONDecodeError, ValueError):
            # Fallback: return raw text in a plain structure
            return {"raw": raw}


consultation_service = ConsultationService()
