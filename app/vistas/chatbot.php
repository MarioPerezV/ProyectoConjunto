<!-- ------------------------ CHATBOT WIDGET----------------------------------------------------------- -->
<div id="chatbot-widget" style="display: none;">
    <div class="chat-header glass-card text-white p-3 rounded-top d-flex justify-content-between align-items-center"
        style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h5 class="mb-0 text-neon-cyan">Agente Vicho</h5>
        <div class="d-flex align-items-center gap-2">
            <button id="restart-chat" class="btn btn-sm btn-outline-light border-0 p-1" title="Reiniciar conversación">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                    <path
                        d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                </svg>
            </button>
            <button id="close-chat" class="btn-close btn-close-white" aria-label="Cerrar"></button>
        </div>
    </div>
    <div class="chat-body p-3 overflow-auto" style="height: 300px;">
    </div>
    <div class="chat-footer p-3 border-top border-secondary d-flex">
        <input type="text" id="user-input" class="form-control me-2 bg-transparent text-white border-secondary"
            placeholder="Escribe tu mensaje...">
        <button id="send-button" class="btn btn-neon rounded-pill">Enviar</button>
    </div>
</div>
<button id="open-chat-button" class="btn btn-neon rounded-circle shadow"
    style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; z-index: 1000; border: 1px solid rgb(156, 153, 255);">
    Bot<!-- <i class="fas fa-comment-dots"></i> -->
</button>
<style>
    /* Estilos Básicos para el Widget de Chat */
    #chatbot-widget {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 350px;
        max-width: 90%;
        background: rgba(13, 13, 43, 0.95);
        /* Dark Glass */
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
        background: rgba(255, 255, 255, 0.1);
        /* Glass White/Grey */
        border: 1px solid rgba(120, 1, 255, 0.5);
        /* Neon Purple Border */
        color: white;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }

    .user-message {
        background: rgba(0, 255, 255, 0.2);
        /* Glass Neon Cyan */
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
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: rgba(120, 1, 255, 0.5);
        /* Neon Purple Scroll */
        border-radius: 10px;
    }

    .chat-body::-webkit-scrollbar-thumb:hover {
        background: #7801ff;
    }

    #restart-chat:hover svg {
        color: #00FFFF;
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }
</style>
<script>
    // Manejar el CHATBOT ----------------------------------------------------------------------
    const chatbotWidget = document.getElementById('chatbot-widget');
    const openChatButton = document.getElementById('open-chat-button');
    const closeChatButton = document.getElementById('close-chat');
    const restartChatButton = document.getElementById('restart-chat');
    const chatBody = document.querySelector('#chatbot-widget .chat-body');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');

    // URL del endpoint del backend de chatbot (Python/FastAPI)
    const chatbotApiUrl = '<?= defined('CHATBOT_API_URL') ? CHATBOT_API_URL : 'http://localhost:8000/api/chat'?>';

    // Manejo de thread_id en localStorage
    let currentThreadId = localStorage.getItem('chatbot_thread_id');

    function getThreadId() {
        if (!currentThreadId) {
            currentThreadId = self.crypto.randomUUID();
            localStorage.setItem('chatbot_thread_id', currentThreadId);
        }
        return currentThreadId;
    }

    function resetConversation() {
        localStorage.removeItem('chatbot_thread_id');
        currentThreadId = null;
        chatBody.innerHTML = '';
        startNewConversation();
    }

    function startNewConversation() {
        getThreadId();
        // Si el chat está vacío, mostramos el mensaje de bienvenida predefinido
        if (chatBody.innerHTML.trim() === '') {
            appendBotMessage("¡Hola! Soy Vicho, tu asistente virtual. ¿En qué puedo ayudarte hoy?");
        }
    }

    // --- Funcionalidad para abrir/cerrar el widget ---
    openChatButton.addEventListener('click', function () {
        if (chatbotWidget.style.display === 'none') {
            chatbotWidget.style.display = 'flex';
            userInput.focus();
            startNewConversation();
            scrollToBottom();
        } else {
            chatbotWidget.style.display = 'none';
        }
    });

    closeChatButton.addEventListener('click', function () {
        chatbotWidget.style.display = 'none';
    });

    restartChatButton.addEventListener('click', function () {
        if (confirm('¿Deseas reiniciar la conversación?')) {
            resetConversation();
        }
    });

    // --- Funcionalidad para enviar mensajes ---
    function sendMessage() {
        const messageText = userInput.value.trim();
        if (messageText === '') return;

        appendMessage(messageText, 'user-message');
        userInput.value = '';
        sendUserMessageToBot(messageText);
    }

    function sendUserMessageToBot(messageText) {
        const threadId = getThreadId();

        fetch(chatbotApiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                message: messageText,
                thread_id: threadId
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
                if (data.response) {
                    appendBotMessage(data.response);
                }
            })
            .catch(error => {
                console.error('Error al comunicarse con el chatbot:', error);
                appendMessage('Disculpa, tengo problemas para comunicarme con el asistente. Inténtalo de nuevo más tarde.', 'bot-message');
            })
            .finally(() => {
                scrollToBottom();
            });
    }

    function appendMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', type);
        messageDiv.textContent = text;
        chatBody.appendChild(messageDiv);
        scrollToBottom();
    }

    function appendBotMessage(text) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', 'bot-message');

        // Convertir saltos de línea a <br> y sanitizar mínimamente
        const formattedText = text.replace(/\n/g, '<br>');
        messageDiv.innerHTML = formattedText;

        chatBody.appendChild(messageDiv);
        scrollToBottom();
    }

    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    sendButton.addEventListener('click', sendMessage);

    userInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Inicializar scroll
    scrollToBottom();
</script>

// Inicializar el scroll por si hay un mensaje de bienvenida grande
scrollToBottom();

</script>