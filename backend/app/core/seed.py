from sqlalchemy import select

from app.core.config import settings
from app.db import async_session_maker
from app.models.user import User, Role


async def create_superuser_if_not_exists() -> None:
    if not settings.first_superuser_email or not settings.first_superuser_password:
        return

    from fastapi_users.password import PasswordHelper

    password_helper = PasswordHelper()

    async with async_session_maker() as session:
        result = await session.execute(
            select(User).where(User.email == settings.first_superuser_email)
        )
        existing_user = result.scalar_one_or_none()

        if existing_user:
            print(f"Superuser already exists: {settings.first_superuser_email}")
            return

        hashed_password = password_helper.hash(settings.first_superuser_password)

        new_user = User(
            email=settings.first_superuser_email,
            hashed_password=hashed_password,
            is_active=True,
            is_superuser=True,
            is_verified=True,
            role=Role.ADMIN,
        )

        session.add(new_user)
        await session.commit()
        await session.refresh(new_user)

        print(f"Superuser created successfully: {settings.first_superuser_email}")
