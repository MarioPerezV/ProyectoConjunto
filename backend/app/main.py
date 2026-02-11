from contextlib import asynccontextmanager

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware

from app.core.config import settings
from app.core.seed import create_superuser_if_not_exists
from app.db import engine
from app.auth.router import auth_router
from app.routes.protected import protected_router


@asynccontextmanager
async def lifespan(app: FastAPI):
    await create_superuser_if_not_exists()
    yield
    await engine.dispose()


app = FastAPI(lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.cors_origins,
    allow_credentials=settings.cors_allow_credentials,
    allow_methods=settings.cors_allow_methods,
    allow_headers=settings.cors_allow_headers,
)

app.include_router(auth_router, prefix="/api")
app.include_router(protected_router, prefix="/api")


@app.get("/")
async def root():
    return {"message": "API is running"}


@app.get("/health")
async def health():
    return {"status": "healthy"}
