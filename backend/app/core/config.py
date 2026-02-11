from pydantic_settings import BaseSettings


class Settings(BaseSettings):
    database_url: str
    secret_key: str
    jwt_algorithm: str = "HS256"
    jwt_access_token_expire_minutes: int = 30

    first_superuser_email: str | None = None
    first_superuser_password: str | None = None

    class Config:
        env_file = ".env"


settings = Settings()
