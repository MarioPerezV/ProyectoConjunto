import uuid
from typing import Annotated, TypedDict
from langchain_google_genai import ChatGoogleGenerativeAI
from langgraph.graph import StateGraph, START, END
from langgraph.graph.message import add_messages
from langchain_core.messages import HumanMessage, AIMessage, SystemMessage
from app.core.config import settings
from app.db import async_session_maker
from app.models.chat_message import ChatMessage
from sqlalchemy import select
from app.core.prompts import CHATBOT_SYSTEM_PROMPT

# Define the state of the graph
class State(TypedDict):
    messages: Annotated[list, add_messages]

class ChatService:
    def __init__(self):
        self.llm = ChatGoogleGenerativeAI(
            model="gemini-2.5-flash-lite",
            google_api_key=settings.gemini_api_key,
            temperature=0.7
        )
        self.workflow = self._create_workflow()
        self.app = self.workflow.compile()

    def _create_workflow(self):
        workflow = StateGraph(State)
        
        async def call_model(state: State):
            # Check if we need to prepend the system prompt
            if not any(isinstance(m, SystemMessage) for m in state["messages"]):
                messages = [SystemMessage(content=CHATBOT_SYSTEM_PROMPT)] + state["messages"]
            else:
                messages = state["messages"]
            
            response = await self.llm.ainvoke(messages)
            return {"messages": [response]}

        workflow.add_node("agent", call_model)
        workflow.add_edge(START, "agent")
        workflow.add_edge("agent", END)
        
        return workflow

    async def get_history(self, thread_id: str):
        async with async_session_maker() as session:
            result = await session.execute(
                select(ChatMessage)
                .where(ChatMessage.thread_id == thread_id)
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

    async def save_message(self, thread_id: str, role: str, content: str):
        async with async_session_maker() as session:
            message = ChatMessage(thread_id=thread_id, role=role, content=content)
            session.add(message)
            await session.commit()

    async def get_response(self, message: str, thread_id: str) -> str:
        # Load history
        history = await self.get_history(thread_id)
        
        # Save user message
        await self.save_message(thread_id, "user", message)
        
        # Prepare state
        input_messages = history + [HumanMessage(content=message)]
        
        # Run graph
        # Note: In a full production app, we'd use a LangGraph checkpointer.
        # For now, we manually manage history to keep the existing DB structure.
        config = {"configurable": {"thread_id": thread_id}}
        result = await self.app.ainvoke({"messages": input_messages}, config=config)
        
        response_text = result["messages"][-1].content
        
        # Save AI response
        await self.save_message(thread_id, "model", response_text)
            
        return response_text

chat_service = ChatService()
