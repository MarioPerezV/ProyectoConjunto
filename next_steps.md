# NEXT STEPS - Integración Frontend con Backend

## 📋 Tareas a Completar

### 1. Reorganizar Estructura de Archivos
Mover los archivos HTML a una carpeta `frontend/`:

```
ProyectoConjunto/
├── index.php  -- Rutas
├── api/
├── backend/
│   └── (ya está listo)
├── config/
└── frontend/
    ├── vistas/
    │   ├── inicio.php
    │   └── chatbot.php
    └── assets/
		├── css/
		│   └── styles.css
		└── js/
			└── auth.js
---

### 2. Servir los Archivos PHP
Utilizamos el hosting de AgenciaGaby para el frontend con su correspondiente base de datos

---

#### 3. No utilzaremos Login con la API de momento

<!-- #### 3.1 Modificar `login.html`
Agrega un `id` a tu formulario y campos:

```html
<form id="loginForm">
  <input type="email" id="email" name="email" required>
  <input type="password" id="password" name="password" required>
  <button type="submit">Iniciar Sesión</button>
</form>

<div id="error-message" style="color: red; display: none;"></div>

<script src="js/auth.js"></script>
```

#### 3.2 Crear `frontend/js/auth.js`
Crea este archivo con el siguiente código:

```javascript
// auth.js - Manejo de autenticación

const API_URL = 'http://localhost:8000'; // URL de tu backend

// Login
document.getElementById('loginForm')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;
  const errorDiv = document.getElementById('error-message');
  
  try {
    const response = await fetch(`${API_URL}/api/auth/jwt/login`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `username=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    });
    
    if (response.ok) {
      const data = await response.json();
      // Guardar token en localStorage
      localStorage.setItem('access_token', data.access_token);
      // Redirigir al dashboard
      window.location.href = 'dashboard.html';
    } else {
      const error = await response.json();
      errorDiv.textContent = 'Credenciales incorrectas';
      errorDiv.style.display = 'block';
    }
  } catch (error) {
    console.error('Error:', error);
    errorDiv.textContent = 'Error de conexión con el servidor';
    errorDiv.style.display = 'block';
  }
});
```
 -->
---

### 4. Proteger el Dashboard -- NO LO UTILIZAREMOS DE MOMENTO

#### 4.1 Modificar `dashboard.html`
Agrega esto al inicio del archivo (dentro de `<head>` o al inicio del `<body>`):

```html
<script>
// Verificar si hay token al cargar la página
window.addEventListener('DOMContentLoaded', () => {
  const token = localStorage.getItem('access_token');
  if (!token) {
    // Si no hay token, redirigir a login
    window.location.href = 'login.html';
  }
});
</script>

<!-- Área para mostrar datos del usuario -->
<div id="user-info">
  <p>Cargando información del usuario...</p>
</div>

<button id="logoutBtn">Cerrar Sesión</button>

<script src="js/dashboard.js"></script>
```

#### 4.2 Crear `frontend/js/dashboard.js`

```javascript
// dashboard.js - Lógica del dashboard

const API_URL = 'http://localhost:8000';

// Obtener información del usuario actual
async function loadUserInfo() {
  const token = localStorage.getItem('access_token');
  
  try {
    const response = await fetch(`${API_URL}/api/users/me`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });
    
    if (response.ok) {
      const user = await response.json();
      displayUserInfo(user);
    } else {
      // Token inválido o expirado
      console.error('Token inválido');
      localStorage.removeItem('access_token');
      window.location.href = 'login.html';
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

// Mostrar información del usuario
function displayUserInfo(user) {
  const userInfoDiv = document.getElementById('user-info');
  userInfoDiv.innerHTML = `
    <h2>Bienvenido, ${user.email}</h2>
    <p>ID: ${user.id}</p>
    <p>Verificado: ${user.is_verified ? 'Sí' : 'No'}</p>
  `;
}

// Logout
document.getElementById('logoutBtn')?.addEventListener('click', () => {
  localStorage.removeItem('access_token');
  window.location.href = 'login.html';
});

// Cargar info al iniciar
loadUserInfo();

---

### 5. Configurar CORS en el Backend
**YO ME ENCARGO DE ESTO** - Solo para que sepas qué hace:

El backend necesita permitir peticiones desde tu servidor frontend (Live Server). Configuré CORS para aceptar requests desde `http://localhost:5500`.

---

## ✅ Checklist de Tareas

- [ ] Crear carpeta `frontend/` y mover archivos HTML
- [ ] Crear carpeta `frontend/js/`
- [ ] Instalar Live Server en VS Code
- [ ] Modificar `login.html` (agregar IDs y script)
- [ ] Crear `js/auth.js`
- [ ] Modificar `dashboard.html` (protección y script)
- [ ] Crear `js/dashboard.js`
- [ ] Probar login con un usuario de prueba
- [ ] Verificar que redirija al dashboard
- [ ] Verificar que muestre datos del usuario
- [ ] Probar logout

---

## 🎯 Flujo Completo

1. Usuario abre `index.html` → botón que lleva a `login.html`
2. Usuario ingresa email/password en `login.html`
3. JavaScript hace POST a `/api/auth/jwt/login`
4. Si es exitoso: guarda token y redirige a `dashboard.html`
5. `dashboard.html` verifica token y hace GET a `/api/users/me`
6. Muestra información del usuario
7. Botón logout borra token y regresa a login

---

## 🆘 Cómo Usar IA para Ayudarte

Si tienes dudas o errores:

1. **Copia el código completo** del archivo donde tienes el problema
2. **Copia el error** de la consola del navegador (F12 → Console)
3. **Pregunta a Claude/ChatGPT:**
   - "Tengo este error [pega error], aquí está mi código [pega código], ¿qué está mal?"
   - "¿Cómo puedo agregar validación al formulario antes de enviar?"
   - "¿Cómo manejo el caso cuando el token expira?"

---

## 📚 Recursos

- **Fetch API:** https://developer.mozilla.org/es/docs/Web/API/Fetch_API
- **LocalStorage:** https://developer.mozilla.org/es/docs/Web/API/Window/localStorage
- **Consola del navegador:** F12 → pestaña "Console" y "Network" para debug

---

## 🚀 Próximos Pasos (después de completar lo anterior)

1. Mejorar UX: spinners de carga, mensajes de error bonitos
2. Validación de formularios en el frontend
3. Manejo de token expirado (refresh automático)
4. Conectar `index.html` con botones de navegación
5. Agregar más funcionalidades al dashboard

---

**¡Manos a la obra!** Empieza por el checklist y ve paso a paso. Cualquier duda, me preguntas.