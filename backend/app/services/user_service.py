from sqlalchemy import select
from sqlalchemy.ext.asyncio import AsyncSession

from app.models.user import User, Role


async def get_user_by_email(session: AsyncSession, email: str) -> User | None:
    result = await session.execute(select(User).where(User.email == email))
    return result.scalar_one_or_none()


async def get_user_by_id(session: AsyncSession, user_id: str) -> User | None:
    result = await session.execute(select(User).where(User.id == user_id))
    return result.scalar_one_or_none()


async def set_user_role(session: AsyncSession, user_id: str, role: Role) -> User | None:
    user = await get_user_by_id(session, user_id)
    if user:
        user.role = role
        await session.commit()
        await session.refresh(user)
    return user


async def make_user_admin(session: AsyncSession, user_id: str) -> User | None:
    return await set_user_role(session, user_id, Role.ADMIN)


async def make_user_user(session: AsyncSession, user_id: str) -> User | None:
    return await set_user_role(session, user_id, Role.USER)
