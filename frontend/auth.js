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