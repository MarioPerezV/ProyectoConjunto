// js/register.js - Lógica de registro

const API_URL = 'http://localhost:8000';

document.getElementById('registerForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const messageDiv = document.getElementById('register-message');
    
    // Resetear mensajes
    messageDiv.style.display = 'none';
    messageDiv.className = 'text-center text-sm font-medium mt-4';

    // Validar contraseñas
    if (password !== confirmPassword) {
        messageDiv.textContent = 'Las contraseñas no coinciden';
        messageDiv.classList.add('text-red-500');
        messageDiv.style.display = 'block';
        return;
    }

    try {
        const response = await fetch(`${API_URL}/api/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok) {
            messageDiv.textContent = '¡Registro exitoso! Redirigiendo al login...';
            messageDiv.classList.add('text-green-500');
            messageDiv.style.display = 'block';
            
            // Deshabilitar botón para evitar doble envío
            const btn = e.target.querySelector('button[type="submit"]');
            if (btn) btn.disabled = true;

            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
        } else {
            // Manejar errores específicos
            let errorMsg = 'Error al registrar usuario';
            if (data.detail) {
                if (data.detail === 'REGISTER_USER_ALREADY_EXISTS') {
                    errorMsg = 'Este correo ya está registrado';
                } else {
                    errorMsg = typeof data.detail === 'string' ? data.detail : JSON.stringify(data.detail);
                }
            }
            
            messageDiv.textContent = errorMsg;
            messageDiv.classList.add('text-red-500');
            messageDiv.style.display = 'block';
        }
    } catch (error) {
        console.error('Error:', error);
        messageDiv.textContent = 'Error de conexión con el servidor';
        messageDiv.classList.add('text-red-500');
        messageDiv.style.display = 'block';
    }
});