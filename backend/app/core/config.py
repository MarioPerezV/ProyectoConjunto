from typing import Any

from pydantic import field_validator
from pydantic_settings import BaseSettings


class Settings(BaseSettings):
    database_url: str = "sqlite+aiosqlite:///./app.db"
    gemini_api_key: str

    cors_origins_raw: str = "http://localhost:5500,http://127.0.0.1:5500"
    cors_allow_credentials: bool = True
    cors_allow_methods_raw: str = "*"
    cors_allow_headers_raw: str = "*"

    @property
    def cors_origins(self) -> list[str]:
        if self.cors_origins_raw == "*":
            return ["*"]
        return [origin.strip() for origin in self.cors_origins_raw.split(",")]

    @property
    def cors_allow_methods(self) -> list[str]:
        if self.cors_allow_methods_raw == "*":
            return ["*"]
        return [method.strip() for method in self.cors_allow_methods_raw.split(",")]

    @property
    def cors_allow_headers(self) -> list[str]:
        if self.cors_allow_headers_raw == "*":
            return ["*"]
        return [header.strip() for header in self.cors_allow_headers_raw.split(",")]

    class Config:
        env_file = ".env"
        extra = "ignore"


settings = Settings()
