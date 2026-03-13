from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from app.core.config import settings
from app.routes.chat import chat_router
from app.routes.consultation import consultation_router

app = FastAPI(title="Web Consultancy Chatbot API")

app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.cors_origins,
    allow_credentials=settings.cors_allow_credentials,
    allow_methods=settings.cors_allow_methods,
    allow_headers=settings.cors_allow_headers,
)

app.include_router(chat_router, prefix="/api")
app.include_router(consultation_router, prefix="/api/consultation")

@app.get("/")
async def root():
    return {"message": "Web Consultancy Chatbot API is running"}

@app.get("/health")
async def health():
    return {"status": "healthy"}
