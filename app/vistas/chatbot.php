<!-- ------------------------ CHATBOT WIDGET----------------------------------------------------------- -->
<div id="chatbot-widget" class="hidden">
    <div
        class="chat-header glass-card text-white p-4 rounded-t-2xl flex justify-between items-center border-b border-white/10 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center border border-primary/50">
                <span class="material-symbols-outlined text-primary text-2xl">smart_toy</span>
            </div>
            <div>
                <h5 class="mb-0 font-bold text-lg tracking-tight">Nexus</h5>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">En línea</span>
                </div>
            </div>
        </div>
        <div class="flex align-items-center gap-2">
            <button id="restart-chat" class="p-2 text-slate-400 hover:text-primary transition-colors"
                title="Reiniciar conversación">
                <span class="material-symbols-outlined text-xl">restart_alt</span>
            </button>
            <button id="toggle-fullscreen"
                class="hidden md:block p-2 text-slate-400 hover:text-primary transition-colors"
                title="Pantalla completa">
                <span id="fullscreen-icon" class="material-symbols-outlined text-xl">fullscreen</span>
            </button>
            <button id="close-chat" class="p-2 text-slate-400 hover:text-red-400 transition-colors" title="Cerrar">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
    </div>

    <div class="chat-body-container flex-grow overflow-hidden flex flex-col items-center">
        <div class="chat-body p-4 overflow-y-auto w-full max-w-4xl flex flex-col space-y-4">
            <!-- Messages will be injected here -->
        </div>
    </div>

    <!-- Thinking Indicator -->
    <div id="thinking-indicator" class="hidden px-4 py-2 border-t border-white/5 bg-slate-900/40 shrink-0">
        <div class="flex items-center justify-center w-full">
            <div class="flex items-center gap-2 text-slate-400 text-xs italic max-w-4xl w-full">
                <div class="flex gap-1">
                    <span class="w-1 h-1 bg-primary rounded-full animate-bounce"></span>
                    <span class="w-1 h-1 bg-primary rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1 h-1 bg-primary rounded-full animate-bounce [animation-delay:0.4s]"></span>
                </div>
                Nexus está pensando...
            </div>
        </div>
    </div>

    <div class="chat-footer p-4 border-t border-white/10 bg-slate-900/60 backdrop-blur-md shrink-0 flex justify-center">
        <div class="relative flex items-center gap-2 w-full max-w-4xl">
            <input type="text" id="user-input"
                class="w-full bg-slate-800/50 text-white border border-slate-700 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-slate-500"
                placeholder="Escribe tu mensaje...">
            <button id="send-button"
                class="absolute right-2 p-2 text-primary hover:text-white hover:bg-primary/20 rounded-lg transition-all">
                <span class="material-symbols-outlined">send</span>
            </button>
        </div>
    </div>
</div>

<button id="open-chat-button"
    class="fixed bottom-6 right-6 w-16 h-16 bg-primary text-background-dark rounded-full shadow-[0_0_20px_rgba(13,185,242,0.4)] flex items-center justify-center z-[1000] hover:scale-110 transition-transform active:scale-95 group border-2 border-primary/20">
    <span class="material-symbols-outlined text-3xl transition-transform group-hover:rotate-12">forum</span>
    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-background-dark rounded-full"></span>
</button>

<style>
    #chatbot-widget {
        position: fixed;
        bottom: 100px;
        right: 24px;
        width: 400px;
        height: 600px;
        max-width: calc(100vw - 48px);
        max-height: calc(100vh - 140px);
        background: rgba(16, 30, 34, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(13, 185, 242, 0.2);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    #chatbot-widget.hidden {
        display: none !important;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }

    #chatbot-widget.fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100vw !important;
        max-height: 100vh !important;
        bottom: 0 !important;
        right: 0 !important;
        border-radius: 0 !important;
        z-index: 2000;
    }

    @media (max-width: 768px) {
        #chatbot-widget {
            bottom: 0 !important;
            right: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            max-width: 100vw !important;
            max-height: 100vh !important;
            border-radius: 0 !important;
            z-index: 2000;
        }
    }

    .message {
        max-width: 85%;
        padding: 12px 16px;
        border-radius: 20px;
        font-size: 0.925rem;
        line-height: 1.5;
        position: relative;
        animation: messageFadeIn 0.3s ease-out forwards;
    }

    @keyframes messageFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bot-message {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .user-message {
        background: #0db9f2;
        color: #101e22;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        font-weight: 500;
        box-shadow: -2px 2px 10px rgba(13, 185, 242, 0.2);
    }

    /* Custom Scrollbar */
    .chat-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background: rgba(13, 185, 242, 0.2);
        border-radius: 10px;
    }

    .chat-body::-webkit-scrollbar-thumb:hover {
        background: rgba(13, 185, 242, 0.4);
    }
</style>

<script>
    const chatbotWidget = document.getElementById('chatbot-widget');
    const openChatButton = document.getElementById('open-chat-button');
    const closeChatButton = document.getElementById('close-chat');
    const restartChatButton = document.getElementById('restart-chat');
    const toggleFullscreenButton = document.getElementById('toggle-fullscreen');
    const fullscreenIcon = document.getElementById('fullscreen-icon');
    const chatBody = document.querySelector('.chat-body');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-button');
    const thinkingIndicator = document.getElementById('thinking-indicator');

    const chatbotApiUrl = '<?= defined('CHATBOT_API_URL') ? CHATBOT_API_URL : 'http://localhost:8000/api/chat'?>';
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
        if (chatBody.querySelectorAll('.message').length === 0) {
            setTimeout(() => {
                appendBotMessage("¡Hola! Soy **Nexus**, tu asistente inteligente. ¿Cómo puedo ayudarte hoy con tus proyectos o consultas técnicas?");
            }, 500);
        }
    }

    function toggleChat() {
        const isHidden = chatbotWidget.classList.contains('hidden');
        if (isHidden) {
            chatbotWidget.classList.remove('hidden');
            openChatButton.classList.add('hidden'); // Ocultar burbuja al abrir
            userInput.focus();
            startNewConversation();
            scrollToBottom();
        } else {
            chatbotWidget.classList.add('hidden');
            openChatButton.classList.remove('hidden'); // Mostrar burbuja al cerrar
        }
    }

    function toggleFullscreen() {
        chatbotWidget.classList.toggle('fullscreen');
        const isFullscreen = chatbotWidget.classList.contains('fullscreen');
        fullscreenIcon.textContent = isFullscreen ? 'fullscreen_exit' : 'fullscreen';
        scrollToBottom();
    }

    openChatButton.addEventListener('click', toggleChat);
    closeChatButton.addEventListener('click', toggleChat);

    toggleFullscreenButton.addEventListener('click', toggleFullscreen);

    restartChatButton.addEventListener('click', function () {
        if (confirm('¿Deseas reiniciar la conversación con Nexus?')) {
            resetConversation();
        }
    });

    function sendMessage() {
        const messageText = userInput.value.trim();
        if (messageText === '') return;

        appendMessage(messageText, 'user-message');
        userInput.value = '';

        // Mostrar indicador de pensamiento
        thinkingIndicator.classList.remove('hidden');
        scrollToBottom();

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
                if (!response.ok) return response.text().then(text => { throw new Error(text || response.statusText); });
                return response.json();
            })
            .then(data => {
                if (data.response) {
                    appendBotMessage(data.response);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                appendBotMessage('Lo siento, he tenido un pequeño error en mi núcleo. Por favor, intenta de nuevo en un momento.');
            })
            .finally(() => {
                thinkingIndicator.classList.add('hidden');
                scrollToBottom();
            });
    }

    function appendMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', type);

        // Simple markdown-like bold parsing (for Nexus name)
        const formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');

        messageDiv.innerHTML = formatted;
        chatBody.appendChild(messageDiv);
        scrollToBottom();
    }

    function appendBotMessage(text) {
        appendMessage(text, 'bot-message');
    }

    function scrollToBottom() {
        chatBody.scrollTo({
            top: chatBody.scrollHeight,
            behavior: 'smooth'
        });
    }

    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    // Inicializar scroll
    scrollToBottom();
</script>