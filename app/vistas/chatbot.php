<!-- ------------------------ CHATBOT WIDGET----------------------------------------------------------- -->
<div id="chatbot-widget" style="display: none;">
	<div class="chat-header glass-card text-white p-3 rounded-top" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
		<h5 class="mb-0 text-neon-cyan">Agente Vicho</h5>
		<button id="close-chat" class="btn-close btn-close-white" aria-label="Cerrar"></button>
	</div>
	<div class="chat-body p-3 overflow-auto" style="height: 300px;">
	</div>
	<div class="chat-footer p-3 border-top border-secondary d-flex">
		<input type="text" id="user-input" class="form-control me-2 bg-transparent text-white border-secondary" placeholder="Escribe tu mensaje...">
		<button id="send-button" class="btn btn-neon rounded-pill">Enviar</button>
	</div>
</div>
<button id="open-chat-button" class="btn btn-neon rounded-circle shadow" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; z-index: 1000; border: 1px solid rgb(156, 153, 255);">
	Bot<!-- <i class="fas fa-comment-dots"></i> -->
</button>
<style>/* Estilos Básicos para el Widget de Chat */
	#chatbot-widget {
		position: fixed;
		bottom: 90px;
		right: 20px;
		width: 350px;
		max-width: 90%;
		background: rgba(13, 13, 43, 0.95); /* Dark Glass */
		backdrop-filter: blur(10px);
		border: 1px solid rgb(156, 153, 255);
		border-radius: 16px;
		box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
		z-index: 999;
		display: flex;
		flex-direction: column;
		color: white;
	}
	.chat-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.chat-body {
		flex-grow: 1;
		background-color: transparent;
		display: flex;
		flex-direction: column;
	}
	.message {
		max-width: 80%;
		padding: 10px 14px;
		border-radius: 15px;
		margin-bottom: 10px;
	}
	.bot-message {
		background: rgba(255, 255, 255, 0.1); /* Glass White/Grey */
		border: 1px solid rgba(120, 1, 255, 0.5); /* Neon Purple Border */
		color: white;
		align-self: flex-start;
		border-bottom-left-radius: 2px;
	}
	.user-message {
		background: rgba(0, 255, 255, 0.2); /* Glass Neon Cyan */
		border: 1px solid #00FFFF;
		color: white;
		align-self: flex-end;
		border-bottom-right-radius: 2px;
	} 
	/* Ocultar el botón de cerrar en el header por defecto si solo se usa el botón principal para abrir/cerrar */
	#chatbot-widget .btn-close {
		visibility: visible; 
	}    
	/* Estilos para el scroll del chat-body */
	.chat-body::-webkit-scrollbar {
		width: 8px;
	}
	.chat-body::-webkit-scrollbar-track {
		background: rgba(0,0,0,0.3);
		border-radius: 10px;
	}
	.chat-body::-webkit-scrollbar-thumb {
		background: rgba(120, 1, 255, 0.5); /* Neon Purple Scroll */
		border-radius: 10px;
	}
	.chat-body::-webkit-scrollbar-thumb:hover {
		background: #7801ff;
	}
</style>
<script>
    // Manejar el CHATBOT ----------------------------------------------------------------------
    const modalDetalleArticulo = document.getElementById('modalDetalleArticulo');
    /* JS para chatbot */
    const chatbotWidget = document.getElementById('chatbot-widget');
    const openChatButton = document.getElementById('open-chat-button');
    const closeChatButton = document.getElementById('close-chat');
    const chatBody = document.querySelector('#chatbot-widget .chat-body');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');

    // URL del endpoint PHP para el chatbot
    const chatbotApiUrl = '<?= BASE_URL ?>/app/api/chatbot.php';

    // Variable global para almacenar el contexto del chatbot
    let chatbotContext = {
        lastProductId: null // Almacenará el ID del último producto si solo se encontró uno
    };
    // Considera añadir una función para "iniciar nueva conversación" que resetee el contexto y el historial del chat.
    function startNewConversation() {
        chatbotContext.lastProductId = null; // Reinicia el contexto
        chatBody.innerHTML = ''; // Limpia el historial del chat
        // Opcional: añade el mensaje de bienvenida aquí
        // appendMessage('Bienvenid@ a Agencia Gaby, soy tu asistente. ¿Cómo puedo ayudarte hoy?', 'bot-message');
        sendUserMessageToBot(''); // Enviar un mensaje vacío al bot para obtener la bienvenida con opciones
        scrollToBottom();
    }    
    // --- Funcionalidad para abrir/cerrar el widget ---
    openChatButton.addEventListener('click', function() {
        if (chatbotWidget.style.display === 'none') {
            chatbotWidget.style.display = 'flex';
            userInput.focus(); // Pone el foco en el input cuando se abre
            // Llama a esta función al cargar la página para asegurar un estado limpio al inicio. Si el mensaje de bienvenida ya viene del servidor al iniciar, no necesitas el appendMessage aquí.
            startNewConversation();
            scrollToBottom();
        } else {
            chatbotWidget.style.display = 'none';
        }
    });
    closeChatButton.addEventListener('click', function() {
        chatbotWidget.style.display = 'none';
    });
    // --- Funcionalidad para enviar mensajes ---
    function sendMessage() {
        const messageText = userInput.value.trim();
        if (messageText === '') return;
        // 1. Mostrar el mensaje del usuario en el chat
        appendMessage(messageText, 'user-message');
        userInput.value = ''; // Limpiar el input
        // 2. Enviar el mensaje al backend del chatbot (PHP)
        sendUserMessageToBot(messageText);
    }
    // Función auxiliar para manejar el envío y la respuesta del bot
    function sendUserMessageToBot(messageText) {
        // *** DEBUG: Mostrar el contexto ANTES de enviar el mensaje ***
        console.log('Contexto ANTES de enviar:', chatbotContext);

        fetch(chatbotApiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                // Enviamos el mensaje y el contexto actual
                body: JSON.stringify({
                    message: messageText,
                    context: chatbotContext
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(text || response.statusText);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Actualizamos el contexto si el backend lo envía
                if (data.context) {
                    chatbotContext = {
                        ...chatbotContext,
                        ...data.context
                    };
                } else {
                    // Si el backend no envía contexto, resetearlo (o mantener lo necesario)
                    chatbotContext.lastProductId = null;
                }

                // --- MANEJO CENTRALIZADO DE RESPUESTAS DEL BOT ---
                if (data.type === 'rich' && data.message_data) {
                    let messageHtml = `<div class="bot-message mb-2 p-2 rounded">`;
                    if (data.message_data.text) {
                        messageHtml += `<p class="mb-1">${data.message_data.text}</p>`;
                    }
                    if (data.message_data.image_url) {
                        messageHtml += `<img src="${data.message_data.image_url}" alt="${data.message_data.image_alt || 'Imagen del bot'}" class="img-fluid my-2" style="max-width: 150px; max-height: 150px; object-fit: cover;">`;
                    }
                    if (data.message_data.link_url && data.message_data.link_text) {
                        messageHtml += `<a href="${data.message_data.link_url}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-neon text-white mt-2">${data.message_data.link_text}</a>`;
                    }
                    if (data.message_data.title && data.message_data.list_items && Array.isArray(data.message_data.list_items)) {
                        messageHtml += `<h6 class="mt-2">${data.message_data.title}</h6>`;
                        messageHtml += `<ul>`;
                        data.message_data.list_items.forEach(item => {
                            messageHtml += `<li>${item}</li>`;
                        });
                        messageHtml += `</ul>`;
                    }
                    chatBody.insertAdjacentHTML('beforeend', messageHtml);

                } else if (data.type === 'products' && data.products && data.products.length > 0) {
                    let productsHtml = `<div class="bot-message mb-2 p-2 rounded">`;
                    productsHtml += `<h5>${data.message}</h5>`;
                    productsHtml += `<ul class="list-unstyled mb-0">`;
                    data.products.forEach(product => {
                        productsHtml += `<li class="d-flex align-items-center mb-2">`;
                        if (product.imagen_url) {
                            productsHtml += `<img src="${product.imagen_url}" alt="${product.nombre}" class="me-2 rounded" style="width: 50px; height: 50px; object-fit: cover;">`;
                        }
                        productsHtml += `<div>
                                        <strong>${product.nombre}</strong> ($${product.precio})<br>
                                        <a href="${product.url}" target="_blank" rel="noopener noreferrer" class="text-primary small">Ver detalles</a>
                                    </div>`;
                        productsHtml += `</li>`;
                    });
                    productsHtml += `</ul></div>`;
                    chatBody.insertAdjacentHTML('beforeend', productsHtml);

                } else if (data.type === 'options' && data.options && Array.isArray(data.options)) {
                    // --- NUEVA LÓGICA PARA RENDERIZAR BOTONES DE OPCIONES ---
                    let optionsHtml = `<div class="bot-message mb-2 p-2 rounded">`;
                    optionsHtml += `<p class="mb-1">${data.message}</p>`;
                    optionsHtml += `<div class="d-flex flex-column gap-2 mt-2">`;
                    data.options.forEach(option => {
                        optionsHtml += `<button class="btn btn-sm btn-neon bot-option-button text-white" data-value="${option.value}">${option.text}</button>`;
                    });
                    optionsHtml += `</div></div>`;
                    chatBody.insertAdjacentHTML('beforeend', optionsHtml);

                    // Añadir event listeners a los nuevos botones
                    chatBody.querySelectorAll('.bot-option-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const optionValue = this.dataset.value;
                            // Simula que el usuario escribió el valor del botón
                            appendMessage(this.textContent, 'user-message'); // Muestra el texto del botón como si el usuario lo hubiera dicho
                            sendUserMessageToBot(optionValue); // Envía el valor al backend
                        });
                    });

                } else {
                    // Fallback genérico si el tipo no es 'rich', 'products' u 'options'
                    let fallbackMessage = data.message || 'Lo siento, no pude obtener una respuesta válida en este momento.';
                    let fallbackHtml = `<div class="bot-message mb-2 p-2 rounded">`;
                    fallbackHtml += `<p class="mb-0">${fallbackMessage}</p>`;
                    fallbackHtml += `</div>`;
                    chatBody.insertAdjacentHTML('beforeend', fallbackHtml);
                }
            })
            .catch(error => {
                console.error('Error al comunicarse con el chatbot:', error);
                appendMessage('Disculpa, tengo problemas para comunicarme con el asistente. Inténtalo de nuevo más tarde.', 'bot-message');
                chatbotContext.lastProductId = null;
            })
            .finally(() => {
                scrollToBottom();
            });
    }
    // --- Función para agregar mensajes al chat ---
    function appendMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', type);
        // Si el mensaje viene con HTML (como enlaces), usamos innerHTML.
        // Si solo esperas texto plano, puedes usar textContent para mayor seguridad contra XSS.
        // Para este caso con enlaces generados por el bot, innerHTML es necesario.
        messageDiv.innerHTML = text;
        chatBody.appendChild(messageDiv);
    }
    // --- Función para desplazar el chat al final ---
    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    // --- Event Listeners para enviar mensaje ---
    sendButton.addEventListener('click', sendMessage);

    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    // Inicializar el scroll por si hay un mensaje de bienvenida grande
    scrollToBottom();

</script>