from fastapi import APIRouter, HTTPException
from pydantic import BaseModel
from app.services.consultation_service import consultation_service

consultation_router = APIRouter()


class ConsultationRequest(BaseModel):
    message: str
    session_id: str


class ConsultationResponse(BaseModel):
    response: str
    session_id: str
    report_ready: bool
    turn: int


class ReportResponse(BaseModel):
    report: str
    session_id: str


class Message(BaseModel):
    role: str
    content: str


class HistoryResponse(BaseModel):
    messages: list[Message]
    session_id: str


@consultation_router.post("/chat", response_model=ConsultationResponse)
async def consultation_chat(request: ConsultationRequest):
    try:
        result = await consultation_service.get_response(request.message, request.session_id)
        return ConsultationResponse(
            response=result["response"],
            session_id=request.session_id,
            report_ready=result["report_ready"],
            turn=result["turn"],
        )
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))


@consultation_router.get("/history/{session_id}", response_model=HistoryResponse)
async def get_history(session_id: str):
    try:
        messages = await consultation_service.get_session_history(session_id)
        return HistoryResponse(messages=messages, session_id=session_id)
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))


@consultation_router.get("/report/{session_id}", response_model=ReportResponse)
async def get_report(session_id: str):
    try:
        report = await consultation_service.generate_report(session_id)
        return ReportResponse(report=report, session_id=session_id)
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
