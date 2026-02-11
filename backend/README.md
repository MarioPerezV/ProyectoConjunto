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
- Seed automático de superusuario al iniciar la app
- CORS configurable desde variables de entorno

## Estructura de Proyecto

```
backend/
├── app/
│   ├── main.py              # Entry point de FastAPI
│   ├── db.py                # Configuración de DB
│   ├── core/
│   │   ├── config.py        # Pydantic Settings
│   │   ├── security.py      # JWT utils
│   │   └── seed.py          # Seed de superusuario
│   ├── models/
│   │   └── user.py          # User model con role
│   ├── auth/
│   │   ├── auth.py          # JWT strategy
│   │   ├── deps.py          # Dependencias de auth
│   │   ├── manager.py       # UserManager
│   │   ├── schemas.py       # Pydantic schemas
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

Para crear automáticamente un superusuario al iniciar la app, configura estas variables en `.env`:
```
FIRST_SUPERUSER_EMAIL=admin@example.com
FIRST_SUPERUSER_PASSWORD=admin123
```

Esta funcionalidad es útil para desarrollo y testing. En producción, usa contraseñas seguras o no uses el seed.

**Configuración de CORS**

El backend tiene soporte para CORS configurado desde variables de entorno. Por defecto, permite peticiones desde:
- `http://localhost:5500`
- `http://127.0.0.1:5500`

Para agregar más orígenes permitidos, edita `.env`:
```
CORS_ORIGINS_RAW=http://localhost:5500,http://127.0.0.1:5500,https://mi-dominio.com
```

Para permitir todos los orígenes (no recomendado en producción):
```
CORS_ORIGINS_RAW=*
```

Otras opciones de CORS:
- `CORS_ALLOW_CREDENTIALS=true` - Permite envío de cookies/headers de autenticación
- `CORS_ALLOW_METHODS_RAW=*` - Métodos HTTP permitidos (GET, POST, PUT, DELETE, etc.)
- `CORS_ALLOW_HEADERS_RAW=*` - Headers permitidos en las peticiones

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

## Superuser Seed

Al iniciar la aplicación, si se configuran las variables de entorno `FIRST_SUPERUSER_EMAIL` y `FIRST_SUPERUSER_PASSWORD`, se creará automáticamente un superusuario con las siguientes características:
- Email y password configurados en las variables
- `is_superuser=True` - Acceso completo a la API
- `is_verified=True` - Email verificado
- `role=admin` - Rol administrativo
- `is_active=True` - Cuenta activa

El seed es idempotente: si el usuario ya existe, no se crea nuevamente.

### Ejemplo de uso con superuser

```bash
# Login con el superuser configurado en .env
curl -X POST http://localhost:8000/api/auth/jwt/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=admin@example.com&password=admin123"

# La respuesta incluye el access_token
{
  "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "token_type": "bearer"
}

# Usar el token para acceder a endpoints protegidos
curl http://localhost:8000/api/admin \
  -H "Authorization: Bearer <token>"
```

## CORS Configuration

El backend utiliza CORS (Cross-Origin Resource Sharing) para permitir peticiones desde orígenes específicos, como el frontend.

### Configuración en .env

```bash
# Orígenes permitidos (separados por comas)
CORS_ORIGINS_RAW=http://localhost:5500,http://127.0.0.1:5500

# Permitir credenciales (cookies, auth headers)
CORS_ALLOW_CREDENTIALS=true

# Métodos HTTP permitidos
CORS_ALLOW_METHODS_RAW=*

# Headers permitidos
CORS_ALLOW_HEADERS_RAW=*
```

### Ejemplos de Configuración

**Para desarrollo con Live Server (puerto 5500):**
```bash
CORS_ORIGINS_RAW=http://localhost:5500,http://127.0.0.1:5500
```

**Para múltiples orígenes:**
```bash
CORS_ORIGINS_RAW=http://localhost:5500,https://dev.misitio.com,https://prod.misitio.com
```

**Para permitir todos los orígenes (⚠️ NO recomendado en producción):**
```bash
CORS_ORIGINS_RAW=*
```

**Para métodos específicos:**
```bash
CORS_ALLOW_METHODS_RAW=GET,POST,PUT,DELETE,PATCH
```

### Verificación de CORS

Para verificar que CORS está funcionando correctamente:

```bash
curl -v http://localhost:8000/api/health \
  -H "Origin: http://localhost:5500"
```

Deberías ver en los headers de respuesta:
```
access-control-allow-credentials: true
access-control-allow-origin: http://localhost:5500
```
