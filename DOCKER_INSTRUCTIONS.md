# Guía para ejecutar el proyecto con Docker en Ubuntu

Esta configuración te permite correr tanto la parte de **PHP** (frontend y vistas heredadas) como la de **Python/FastAPI** (backend nuevo) y la base de datos **MySQL**, sin necesidad de instalar nada localmente excepto Docker.

## Requisitos previos

Asegúrate de tener instalados:
1. **Docker**: `sudo apt update && sudo apt install docker.io`
2. **Docker Compose**: `sudo apt install docker-compose`

## Estructura de archivos creada

He añadido los siguientes archivos al proyecto:
- `docker-compose.yml`: Define los servicios (db, php-app, python-backend).
- `php.Dockerfile`: Configuración para el contenedor de PHP (con Apache y PDO MySQL).
- `backend/python.Dockerfile`: Configuración para el contenedor de FastAPI.

## Pasos para iniciar el proyecto

1.  **Abrir una terminal** en la carpeta raíz del proyecto (`/home/bixo/Documentos/ProyectoConjunto`).
2.  **Construir e iniciar los contenedores**:
    ```bash
    docker-compose up --build -d
    ```
3.  **Verificar que los servicios estén corriendo**:
    ```bash
    docker-compose ps
    ```

## Direcciones de acceso

- **Aplicación PHP (Frontend)**: [http://localhost:8080](http://localhost:8080)
- **API FastAPI (Backend)**: [http://localhost:8000](http://localhost:8000)
- **Documentación API (Swagger)**: [http://localhost:8000/docs](http://localhost:8000/docs)

## Base de Datos (MySQL)

El servicio de base de datos se configura automáticamente con:
- **Host**: `db` (dentro de Docker)
- **Puerto**: `3306`
- **Usuario**: `mariope1_gaby`
- **Contraseña**: `2025pLR8aUBkhM`
- **Nombre BD**: `mariope1_agencia`

> **Nota Importante**: Actualmente no he encontrado un archivo `.sql` para inicializar las tablas de MySQL. Si tienes un volcado de la base de datos, puedes importarlo así:
> ```bash
> docker exec -i mysql-db mysql -u mariope1_gaby -p2025pLR8aUBkhM mariope1_agencia < tu_base_de_datos.sql
> ```

## Backend Python (FastAPI)

El backend utiliza SQLite por defecto (`app.db` dentro de la carpeta `backend`). Los cambios que hagas en el código de Python se reflejarán automáticamente gracias al modo hot-reload.

## Solución de problemas comunes

- **Errores de permisos**: Si Docker te da errores de permisos, prueba ejecutando con `sudo` o añade tu usuario al grupo docker: `sudo usermod -aG docker $USER` (requiere reiniciar sesión).
- **Archivos faltantes**: He notado que `app/api/apichatbot.php` intenta cargar archivos en `app/modelos/` que parecen no existir todavía. Asegúrate de que todos los modelos necesarios estén en su lugar.
- **Error de conexión DB en PHP**: Asegúrate de que el archivo `.env` en la raíz tenga `DB_HOST="db"` cuando uses Docker, o confía en las variables de entorno que Docker Compose ya está inyectando.
