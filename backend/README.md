# Backend API - FastAPI + fastapi-users

Backend para autenticación y autorización con FastAPI y fastapi-users.

## Características

- FastAPI con async/await
- Autenticación JWT stateless
- fastapi-users para gestión de usuarios
- Roles personalizados (USER, ADMIN)
- SQLAlchemy con SQLite
- Migraciones con Alembic
- Pydantic Settings para configuración
- Rutas API con prefijo `/api/`

## Estructura de Proyecto

```
backend/
├── app/
│   ├── main.py              # Entry point de FastAPI
│   ├── db.py                # Configuración de DB
│   ├── core/
│   │   ├── config.py        # Pydantic Settings
│   │   └── security.py      # JWT utils
│   ├── models/
│   │   └── user.py          # User model con role
│   ├── auth/
│   │   ├── auth.py          # JWT strategy
│   │   ├── deps.py          # Dependencias de auth
│   │   ├── manager.py       # UserManager
│   │   └── router.py        # Rutas de auth
│   ├── routes/
│   │   └── protected.py     # Rutas protegidas
│   └── services/
│       └── user_service.py  # Lógica de negocio
├── alembic/                 # Migraciones
├── requirements.txt         # Dependencias
├── .env.example            # Template de variables
└── alembic.ini             # Config de Alembic
```

## Instalación

1. **Crear y activar entorno virtual**

```bash
cd backend
python -m venv venv
source venv/bin/activate  # Linux/Mac
# venv\Scripts\activate  # Windows
```

2. **Instalar dependencias**

```bash
pip install -r requirements.txt
```

3. **Configurar variables de entorno**

```bash
cp .env.example .env
# Editar .env con tus valores
```

4. **Crear migración inicial**

```bash
alembic revision --autogenerate -m "Initial migration"
```

5. **Aplicar migraciones**

```bash
alembic upgrade head
```

6. **Correr servidor**

```bash
uvicorn app.main:app --reload --host 0.0.0.0 --port 8000
```

## API Endpoints

Todas las rutas de API están prefijadas con `/api/`.

### Auth

- `POST /api/auth/register` - Registrar nuevo usuario
- `POST /api/auth/jwt/login` - Login (retorna JWT token)
- `POST /api/auth/jwt/logout` - Logout
- `POST /api/auth/forgot-password` - Solicitar reset password
- `POST /api/auth/reset-password` - Resetear password
- `POST /api/auth/request-verify-token` - Solicitar token de verificación
- `POST /api/auth/verify` - Verificar email
- `GET /api/users/me` - Obtener usuario actual
- `PATCH /api/users/me` - Actualizar usuario actual
- `GET /api/users/{id}` - Obtener usuario por ID
- `PATCH /api/users/{id}` - Actualizar usuario por ID
- `DELETE /api/users/{id}` - Eliminar usuario por ID

### Protected

- `GET /` - API root (sin prefijo)
- `GET /health` - Health check (sin prefijo)
- `GET /api/me` - Información del usuario actual (requiere auth)
- `GET /api/protected` - Endpoint protegido (requiere auth)
- `GET /api/admin` - Endpoint solo para admin (requiere superuser)

## Uso de JWT

Todas las rutas de API usan el prefijo `/api/`. Para acceder a endpoints protegidos, incluye el token en el header:

```
Authorization: Bearer <token>
```

## Roles

Los usuarios tienen un campo `role` que puede ser:
- `user` - Rol por defecto
- `admin` - Rol administrativo

Para convertir un usuario en admin, usa el servicio `make_user_admin` o marca `is_superuser=True`.

## Ejemplo de Flujo

1. **Registrar usuario**
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'
```

2. **Login**
```bash
curl -X POST http://localhost:8000/api/auth/jwt/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=user@example.com&password=password123"
```

3. **Acceder endpoint protegido**
```bash
curl http://localhost:8000/api/me \
  -H "Authorization: Bearer <token>"
```

## Desarrollo

- El servidor se recarga automáticamente con `--reload`
- La DB se crea en `backend/app.db`
- Los logs de migraciones se guardan en consola
