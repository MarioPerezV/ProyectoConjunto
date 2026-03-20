<?php
// Aseguramos que bootstrap ya fue cargado desde index.php
// CONSULTATION_API_URL puede definirse en .env o usa el valor por defecto
$consultationApiUrl = $_ENV['CONSULTATION_API_URL'] ?? 'http://localhost:8000/api/consultation';
?>
<!DOCTYPE html>
<html class="dark" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Auto Consulta de Negocio | Maquina Virtual</title>
    <meta name="description" content="Realiza una consulta inteligente sobre las necesidades de tu negocio y recibe un informe personalizado." />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0db9f2",
                        "background-light": "#f5f8f8",
                        "background-dark": "#101e22",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #101e22; }

        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(16, 30, 34, 0.85);
        }

        /* --- Chat messages --- */
        .message {
            max-width: 78%;
            padding: 12px 18px;
            border-radius: 20px;
            font-size: 0.9rem;
            line-height: 1.6;
            animation: messageFadeIn 0.35s ease-out forwards;
        }
        .bot-message {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        .user-message {
            background: #0db9f2;
            color: #101e22;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
            font-weight: 500;
        }

        @keyframes messageFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* --- Progress steps --- */
        .step { transition: all 0.4s ease; }
        .step.active   { color: #0db9f2; }
        .step.done     { color: #22d3ee; }
        .step.pending  { color: #475569; }
        .step-dot { width:10px; height:10px; border-radius:50%; transition: all 0.4s ease; }
        .step-dot.active  { background: #0db9f2; box-shadow: 0 0 8px #0db9f2; }
        .step-dot.done    { background: #22d3ee; }
        .step-dot.pending { background: #334155; }

        /* --- Chat Scrollbar --- */
        #chat-body::-webkit-scrollbar { width: 5px; }
        #chat-body::-webkit-scrollbar-track { background: transparent; }
        #chat-body::-webkit-scrollbar-thumb { background: rgba(13,185,242,0.2); border-radius:10px; }
        #chat-body::-webkit-scrollbar-thumb:hover { background: rgba(13,185,242,0.4); }

        /* --- Report Scrollbar --- */
        #report-body::-webkit-scrollbar { width: 5px; }
        #report-body::-webkit-scrollbar-track { background: transparent; }
        #report-body::-webkit-scrollbar-thumb { background: rgba(13,185,242,0.2); border-radius:10px; }

        /* --- Structured Report Sections --- */
        .report-section {
            border-radius: 12px;
            padding: 20px 24px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 16px;
            animation: messageFadeIn 0.4s ease-out forwards;
        }
        .report-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #0db9f2;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(13,185,242,0.15);
        }
        .report-section-title .material-symbols-outlined { font-size: 1.1rem; }
        .report-empresa-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .report-empresa-item {
            background: rgba(13,185,242,0.06);
            border-radius: 8px;
            padding: 10px 14px;
        }
        .report-empresa-item-label {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            margin-bottom: 4px;
        }
        .report-empresa-item-value {
            font-size: 0.88rem;
            color: #e2e8f0;
            font-weight: 500;
        }
        .report-text-content {
            font-size: 0.875rem;
            color: #cbd5e1;
            line-height: 1.75;
        }
        .report-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .report-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.875rem;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .report-list li::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #0db9f2;
            margin-top: 7px;
            flex-shrink: 0;
        }
        .report-oportunidad-card {
            background: linear-gradient(135deg, rgba(13,185,242,0.06) 0%, rgba(13,185,242,0.02) 100%);
            border: 1px solid rgba(13,185,242,0.12);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 10px;
        }
        .report-oportunidad-card:last-child { margin-bottom: 0; }
        .report-oportunidad-card-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 6px;
        }
        .report-oportunidad-card-desc {
            font-size: 0.82rem;
            color: #94a3b8;
            line-height: 1.65;
        }
        .report-mv-box {
            background: linear-gradient(135deg, rgba(13,185,242,0.1) 0%, rgba(13,185,242,0.03) 100%);
            border: 1px solid rgba(13,185,242,0.25);
            border-radius: 10px;
            padding: 18px 20px;
            font-size: 0.875rem;
            color: #cbd5e1;
            line-height: 1.8;
        }
        .report-pasos-list { counter-reset: pasos; }
        .report-pasos-list li {
            counter-increment: pasos;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .report-pasos-list li::before {
            content: counter(pasos);
            background: rgba(13,185,242,0.15);
            color: #0db9f2;
            font-size: 0.7rem;
            font-weight: 800;
            min-width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .report-raw {
            font-size: 0.85rem;
            color: #94a3b8;
            white-space: pre-wrap;
            line-height: 1.7;
        }

        /* Generate report button glow */
        @keyframes glow-pulse {
            0%   { box-shadow: 0 0 5px rgba(13,185,242,0.4), 0 0 10px rgba(13,185,242,0.2); }
            50%  { box-shadow: 0 0 20px rgba(13,185,242,0.8), 0 0 30px rgba(13,185,242,0.4); }
            100% { box-shadow: 0 0 5px rgba(13,185,242,0.4), 0 0 10px rgba(13,185,242,0.2); }
        }
        .btn-glow { animation: glow-pulse 2s infinite ease-in-out; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-background-dark text-slate-100 font-display min-h-screen flex flex-col">

    <!-- Nav -->
    <nav class="fixed top-0 w-full z-50 border-b border-primary/10 glass-nav">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center text-background-dark">
                    <span class="material-symbols-outlined font-bold text-xl">code</span>
                </div>
                <span class="text-white font-bold">MAQUINA<span class="text-primary"> VIRTUAL</span> spa</span>
            </a>
            <div class="flex items-center gap-2 text-primary text-sm font-bold">
                <span class="material-symbols-outlined text-base">business_center</span>
                Auto Consulta de Negocio
            </div>
        </div>
    </nav>

    <!-- Main layout -->
    <main class="flex-1 pt-20 pb-8 px-4 sm:px-6 max-w-7xl mx-auto w-full flex flex-col lg:flex-row gap-6">

        <!-- LEFT: progress + info -->
        <aside class="lg:w-72 shrink-0 flex flex-col gap-6 mt-6">
            <!-- Progress card -->
            <div class="bg-slate-900/60 border border-slate-800 rounded-xl p-5">
                <h2 class="text-xs font-bold uppercase tracking-widest text-primary mb-4">Progreso de la consulta</h2>
                <div id="progress-steps" class="flex flex-col gap-3">
                    <!-- Steps rendered dynamically by JS -->
                </div>
                <div class="mt-5 pt-4 border-t border-slate-800">
                    <div class="flex justify-between text-xs text-slate-500 mb-1">
                        <span>Completado</span>
                        <span id="progress-pct">0%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-primary rounded-full transition-all duration-500" style="width:0%"></div>
                    </div>
                </div>
            </div>
            <!-- Info card -->
            <div class="bg-slate-900/40 border border-slate-800 rounded-xl p-5 text-sm text-slate-400 leading-relaxed">
                <div class="flex items-center gap-2 mb-3 text-primary font-bold text-xs uppercase tracking-widest">
                    <span class="material-symbols-outlined text-sm">info</span>
                    ¿Cómo funciona?
                </div>
                <p>Nuestro consultor de IA te irá haciendo algunas preguntas sobre tu empresa. Una vez recopilada la información clave, podrás generar un <strong class="text-slate-300">informe de necesidades</strong> personalizado.</p>
                <p class="mt-3 text-slate-500 text-xs">La conversación dura entre 5 y 10 mensajes.</p>
            </div>
        </aside>

        <!-- RIGHT: chat + report -->
        <div class="flex-1 flex flex-col gap-6 mt-6 min-h-0">

            <!-- Chat container -->
            <div id="chat-container" class="flex flex-col bg-slate-900/60 border border-slate-800 rounded-xl overflow-hidden" style="min-height: 480px; max-height: 68vh;">
                <!-- Chat header -->
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-800 shrink-0 bg-slate-900/40">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary/20 rounded-full flex items-center justify-center border border-primary/40">
                            <span class="material-symbols-outlined text-primary text-xl">support_agent</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-white">Consultor IA</p>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">En línea</span>
                            </div>
                        </div>
                    </div>
                    <button id="restart-btn" title="Reiniciar consulta" class="text-slate-500 hover:text-red-400 transition-colors p-1.5">
                        <span class="material-symbols-outlined text-xl">restart_alt</span>
                    </button>
                </div>

                <!-- Messages -->
                <div id="chat-body" class="flex-1 overflow-y-auto p-5 flex flex-col gap-3">
                    <!-- injected by JS -->
                </div>

                <!-- Thinking indicator -->
                <div id="thinking-indicator" class="hidden px-5 py-2 shrink-0">
                    <div class="flex items-center gap-2 text-slate-400 text-xs italic">
                        <div class="flex gap-1">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay:0s"></span>
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay:0.2s"></span>
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce" style="animation-delay:0.4s"></span>
                        </div>
                        Consultor analizando...
                    </div>
                </div>

                <!-- Input -->
                <div class="shrink-0 p-4 border-t border-slate-800 bg-slate-900/40">
                    <div class="relative flex items-end gap-2">
                        <textarea id="user-input"
                            class="w-full bg-slate-800/60 text-white border border-slate-700 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/40 transition-all placeholder:text-slate-500 resize-none overflow-hidden min-h-[48px] max-h-[120px] text-sm"
                            placeholder="Ej: Hola, soy de una constructora y necesito..."
                            rows="1"></textarea>
                        <button id="send-btn" class="absolute right-2 bottom-2 p-2 text-primary hover:text-white hover:bg-primary/20 rounded-lg transition-all">
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Generate Report button (shown when report_ready) --> 
            <div id="generate-report-area" class="hidden">
                <button id="generate-report-btn"
                    class="btn-glow w-full py-4 bg-primary text-background-dark rounded-xl font-extrabold text-lg flex items-center justify-center gap-3 hover:brightness-110 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-xl">description</span>
                    Generar Informe de Necesidades
                </button>
            </div>
        </div>
    </main>

    <!-- Report Modal -->
    <div id="report-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-slate-900 border border-primary/30 rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl animate-fade-in-up">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800 bg-primary/5 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-2xl">summarize</span>
                    <h2 class="font-extrabold text-white text-lg">Informe de Necesidades</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div id="report-loading" class="hidden">
                        <div class="flex items-center gap-2 text-slate-400 text-xs">
                            <svg class="animate-spin h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.84 3 7.938l3-2.647z"></path>
                            </svg>
                            Generando...
                        </div>
                    </div>
                    <button id="close-modal" class="text-slate-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div id="report-body" class="flex-1 overflow-y-auto p-6 md:p-8">
                <!-- Sections injected by JS -->
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-slate-800 bg-slate-900/50 flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                <button id="email-btn" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-lg font-bold text-sm transition-all border border-slate-700">
                    <span class="material-symbols-outlined text-lg">mail</span>
                    Enviar por correo
                </button>
                <button id="download-btn-placeholder" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-background-dark rounded-lg font-bold text-sm hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Descargar PDF
                </button>
            </div>
        </div>
    </div>

    <script>
    (function() {
        // ---- Config ----
        const API_BASE = '<?= rtrim($consultationApiUrl, '/') ?>';
        const STORAGE_KEY = 'consultation_session_id';

        // ---- State ----
        const TOPICS = [
            { label: 'Nombre de la empresa',   icon: 'apartment' },
            { label: 'Rubro o industria',       icon: 'category' },
            { label: 'Tamaño y equipo',         icon: 'group' },
            { label: 'Antigüedad del negocio',  icon: 'history' },
            { label: 'Necesidad principal',     icon: 'lightbulb' },
            { label: 'Desafíos actuales',       icon: 'crisis_alert' },
        ];
        let currentTurn = 0;
        let reportReady = false;
        let sessionId = localStorage.getItem(STORAGE_KEY);

        // ---- DOM refs ----
        const chatBody      = document.getElementById('chat-body');
        const userInput     = document.getElementById('user-input');
        const sendBtn       = document.getElementById('send-btn');
        const thinkingInd   = document.getElementById('thinking-indicator');
        const generateArea  = document.getElementById('generate-report-area');
        const generateBtn   = document.getElementById('generate-report-btn');
        const reportModal   = document.getElementById('report-modal');
        const closeModal    = document.getElementById('close-modal');
        const reportBody    = document.getElementById('report-body');
        const reportLoading = document.getElementById('report-loading');
        const emailBtn      = document.getElementById('email-btn');
        const restartBtn    = document.getElementById('restart-btn');
        const progressSteps = document.getElementById('progress-steps');
        const progressBar   = document.getElementById('progress-bar');
        const progressPct   = document.getElementById('progress-pct');

        // ---- Progress steps init ----
        function renderProgress() {
            progressSteps.innerHTML = '';
            const completedTopics = Math.min(currentTurn, TOPICS.length);
            const pct = Math.round((completedTopics / TOPICS.length) * 100);
            progressBar.style.width = pct + '%';
            progressPct.textContent = pct + '%';

            TOPICS.forEach((topic, i) => {
                let status = 'pending';
                if (i < completedTopics) status = 'done';
                else if (i === completedTopics) status = 'active';

                const el = document.createElement('div');
                el.className = `step ${status} flex items-center gap-2.5`;
                el.innerHTML = `
                    <span class="step-dot ${status} shrink-0"></span>
                    <span class="material-symbols-outlined text-base leading-none">${topic.icon}</span>
                    <span class="text-xs font-medium leading-tight">${topic.label}</span>
                `;
                progressSteps.appendChild(el);
            });
        }

        // ---- Chat helpers ----
        function appendMessage(text, type) {
            const div = document.createElement('div');
            div.className = `message ${type}`;
            div.innerHTML = text.replace(/\n/g, '<br>');
            chatBody.appendChild(div);
            chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: 'smooth' });
        }

        function setLoading(loading) {
            thinkingInd.classList.toggle('hidden', !loading);
            sendBtn.disabled = loading;
            userInput.disabled = loading;
            if (loading) chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: 'smooth' });
        }

        // ---- Start / init ----
        function getOrCreateSession() {
            if (!sessionId) {
                sessionId = self.crypto.randomUUID();
                localStorage.setItem(STORAGE_KEY, sessionId);
            }
            return sessionId;
        }

        async function startConsultation() {
            const sid = getOrCreateSession();
            renderProgress();
            
            setLoading(true);
            try {
                const res = await fetch(`${API_BASE}/history/${sid}`, {
                    headers: { 'ngrok-skip-browser-warning': '69420' }
                });
                if (res.ok) {
                    const data = await res.json();
                    if (data.messages && data.messages.length > 0) {
                        // Re-renderizar historial
                        data.messages.forEach(m => {
                            appendMessage(m.content, m.role === 'user' ? 'user-message' : 'bot-message');
                            if (m.role === 'bot') {
                                currentTurn++;
                                // Verificar si el mensaje del bot contenía la señal de reporte listo
                                if (m.content.includes("Ya tengo suficiente información sobre tu negocio.")) {
                                    reportReady = true;
                                }
                            }
                        });
                        renderProgress();
                        if (reportReady || currentTurn >= 10) {
                            generateArea.classList.remove('hidden');
                            userInput.disabled = true;
                            sendBtn.disabled = true;
                        }
                    } else {
                        // Sin historial, saludo inicial
                        appendMessage("Bienvenido a la consultoría técnica de Maquina Virtual SPA. Para analizar cómo podemos optimizar su negocio con software e inteligencia artificial, necesito recopilar algunos datos básicos. ¿Cuál es el nombre de su empresa?", "bot-message");
                    }
                }
            } catch (err) {
                console.error("Error cargando historial:", err);
            } finally {
                setLoading(false);
            }
        }

        async function sendToApi(message, silent = false) {
            if (!silent) appendMessage(message, 'user-message');
            setLoading(true);

            try {
                const res = await fetch(`${API_BASE}/chat`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'ngrok-skip-browser-warning': '69420' },
                    body: JSON.stringify({ message, session_id: getOrCreateSession() })
                });
                if (!res.ok) throw new Error(await res.text());
                const data = await res.json();

                appendMessage(data.response, 'bot-message');
                currentTurn = data.turn;
                reportReady = data.report_ready;
                renderProgress();

                if (reportReady || currentTurn >= 10) {
                    generateArea.classList.remove('hidden');
                    userInput.disabled = true;
                    sendBtn.disabled = true;
                }
            } catch (err) {
                appendMessage('Ocurrió un error al conectar con el consultor. Por favor intenta nuevamente.', 'bot-message');
            } finally {
                setLoading(false);
            }
        }

        function sendMessage() {
            const text = userInput.value.trim();
            if (!text || userInput.disabled) return;
            userInput.value = '';
            userInput.style.height = 'auto';
            sendToApi(text, false);
        }

        // ---- Generate report ----
        function renderSection(icon, title, contentHtml) {
            return `
            <div class="report-section">
                <div class="report-section-title">
                    <span class="material-symbols-outlined">${icon}</span>
                    ${title}
                </div>
                ${contentHtml}
            </div>`;
        }

        function renderReport(r) {
            if (!r) { reportBody.innerHTML = '<p class="text-slate-400 text-sm">No se pudo generar el informe.</p>'; return; }

            // Fallback for raw text (if LLM did not return valid JSON)
            if (r.raw) {
                reportBody.innerHTML = renderSection('description', 'Informe', `<p class="report-raw">${r.raw}</p>`);
                return;
            }

            let html = '';

            // 1. Empresa
            if (r.empresa) {
                const e = r.empresa;
                const fields = [
                    { label: 'Nombre', value: e.nombre },
                    { label: 'Rubro', value: e.rubro },
                    { label: 'Tamaño', value: e.tamano },
                    { label: 'Antigüedad', value: e.antiguedad },
                ];
                const gridHtml = `<div class="report-empresa-grid">${
                    fields.map(f => `<div class="report-empresa-item">
                        <div class="report-empresa-item-label">${f.label}</div>
                        <div class="report-empresa-item-value">${f.value || '—'}</div>
                    </div>`).join('')
                }</div>`;
                html += renderSection('apartment', 'Datos de la Empresa', gridHtml);
            }

            // 2. Situación actual
            if (r.situacion_actual) {
                html += renderSection('analytics', 'Situación Actual', `<p class="report-text-content">${r.situacion_actual}</p>`);
            }

            // 3. Necesidad principal
            if (r.necesidad_principal) {
                html += renderSection('lightbulb', 'Necesidad Principal', `<p class="report-text-content">${r.necesidad_principal}</p>`);
            }

            // 4. Desafíos
            if (r.desafios && r.desafios.length) {
                const items = r.desafios.map(d => `<li>${d}</li>`).join('');
                html += renderSection('crisis_alert', 'Desafíos Identificados', `<ul class="report-list">${items}</ul>`);
            }

            // 5. Oportunidades
            if (r.oportunidades && r.oportunidades.length) {
                const cards = r.oportunidades.map(o => `
                    <div class="report-oportunidad-card">
                        <div class="report-oportunidad-card-title">${o.titulo}</div>
                        <div class="report-oportunidad-card-desc">${o.descripcion}</div>
                    </div>`).join('');
                html += renderSection('rocket_launch', 'Áreas de Oportunidad', cards);
            }

            // 6. Soluciones MV
            if (r.soluciones_mv) {
                html += renderSection('handshake', 'Soluciones Maquina Virtual SPA', `<div class="report-mv-box">${r.soluciones_mv}</div>`);
            }

            // 7. Próximos pasos
            if (r.proximos_pasos && r.proximos_pasos.length) {
                const items = r.proximos_pasos.map(p => `<li>${p}</li>`).join('');
                html += renderSection('checklist', 'Próximos Pasos Sugeridos', `<ul class="report-list report-pasos-list">${items}</ul>`);
            }

            reportBody.innerHTML = html;
        }

        generateBtn.addEventListener('click', async () => {
            reportModal.classList.remove('hidden');
            reportModal.classList.add('flex');
            reportLoading.classList.remove('hidden');
            reportBody.innerHTML = '';
            generateBtn.disabled = true;

            try {
                const res = await fetch(`${API_BASE}/report/${getOrCreateSession()}`, {
                    headers: { 'ngrok-skip-browser-warning': '69420' }
                });
                if (!res.ok) throw new Error(await res.text());
                const data = await res.json();
                renderReport(data.report);
            } catch (err) {
                reportBody.innerHTML = '<p class="text-red-400 text-sm">Error al generar el informe. Por favor, intenta de nuevo.</p>';
            } finally {
                reportLoading.classList.add('hidden');
            }
        });

        // ---- Modal events ----
        closeModal.addEventListener('click', () => {
            reportModal.classList.add('hidden');
            reportModal.classList.remove('flex');
            generateBtn.disabled = false;
        });

        // Close modal on background click
        reportModal.addEventListener('click', (e) => {
            if (e.target === reportModal) closeModal.click();
        });

        // Email button placeholder
        emailBtn.addEventListener('click', () => {
            alert('Funcionalidad de envío por correo: Esta es una opción placeholder. En una versión futura, esto enviará el informe PDF a tu casilla de correo.');
        });

        // ---- Restart ----
        restartBtn.addEventListener('click', () => {
            if (!confirm('¿Deseas reiniciar la consulta? Se perderá la sesión actual.')) return;
            localStorage.removeItem(STORAGE_KEY);
            sessionId = null;
            currentTurn = 0;
            reportReady = false;
            chatBody.innerHTML = '';
            generateArea.classList.add('hidden');
            reportModal.classList.add('hidden');
            reportModal.classList.remove('flex');
            reportBody.innerHTML = '';
            userInput.disabled = false;
            sendBtn.disabled = false;
            startConsultation();
        });

        // ---- Input events ----
        sendBtn.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', e => {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
        });
        userInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // ---- Init ----
        startConsultation();
    })();
    </script>

</body>
</html>
