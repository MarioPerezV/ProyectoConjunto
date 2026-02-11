from fastapi import APIRouter, Depends, HTTPException

from app.auth.deps import current_active_user, current_superuser
from app.models.user import User

protected_router = APIRouter()


@protected_router.get("/me")
async def get_current_user(user: User = Depends(current_active_user)):
    return {"id": str(user.id), "email": user.email, "role": user.role}


@protected_router.get("/admin")
async def admin_endpoint(user: User = Depends(current_superuser)):
    return {"message": "Welcome admin!", "email": user.email}


@protected_router.get("/protected")
async def protected_endpoint(user: User = Depends(current_active_user)):
    return {
        "message": "This is a protected endpoint",
        "user_id": str(user.id),
        "role": user.role,
    }
