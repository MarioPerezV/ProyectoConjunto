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

    async def generate_report(self, session_id: str) -> str:
        """Generate a structured business needs report from the consultation history."""
        history = await self.get_history(session_id)

        if not history:
            return "No hay suficiente información para generar un informe."

        # Build a full conversation transcript
        transcript_lines = []
        for m in history:
            if isinstance(m, HumanMessage):
                transcript_lines.append(f"Usuario: {m.content}")
            elif isinstance(m, AIMessage):
                transcript_lines.append(f"Consultor: {m.content}")
        transcript = "\n".join(transcript_lines)

        report_prompt = f"""
Eres un analista de negocios senior de Maquina Virtual SPA. Basándote en la siguiente conversación de consulta, genera un informe estructurado y profesional que no solo analice al negocio, sino que también posicione a Maquina Virtual SPA como el aliado ideal para ejecutar estas soluciones.

CONVERSACIÓN:
{transcript}

FORMATO DEL INFORME (usa exactamente estas secciones):
1. DATOS DE LA EMPRESA
   - Nombre, Rubro, Tamaño, Antigüedad

2. SITUACIÓN ACTUAL
   Descripción objetiva de la situación actual del negocio.

3. NECESIDAD PRINCIPAL
   La necesidad o problema más importante que quieren resolver.

4. DESAFÍOS IDENTIFICADOS
   Los desafíos clave mencionados.

5. ÁREAS DE OPORTUNIDAD
   Identifica 2-3 áreas donde la tecnología (Software, IA, Automatización) transformaría el negocio.

6. SOLUCIONES MAQUINA VIRTUAL SPA
   Explica cómo Maquina Virtual SPA puede ayudar específicamente en este caso. Menciona nuestra experiencia en desarrollo de software a medida, integración de agentes de IA y optimización de procesos. Invita al usuario a contactarnos para una consultoría técnica gratuita.

7. PRÓXIMOS PASOS SUGERIDOS
   Recomendaciones concretas y accionables.

Escribe el informe de forma clara, concisa y muy profesional. Solo texto plano, sin markdown ni asteriscos. Asegúrate de que el tono sea inspirador y de confianza. No hagas un informe demasiado largo o puede que no lo lean. Ve al grano y al dolor del cliente.
"""

        llm = self._get_llm()
        report_result = await llm.ainvoke([HumanMessage(content=report_prompt)])
        return report_result.content


consultation_service = ConsultationService()
