<!DOCTYPE html>

<html class="dark" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>DevPortfolio | Desarrollador de Software de Alta Gama</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .glass-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(16, 30, 34, 0.8);
        }

        .skill-card:hover {
            border-color: #0db9f2;
            background-color: rgba(13, 185, 242, 0.05);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 border-b border-primary/10 glass-nav">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center text-background-dark">
                    <span class="material-symbols-outlined font-bold">code</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">DevPortfolio</span>
            </div>
            <div class="hidden md:flex items-center gap-10">
                <a class="text-sm font-medium text-slate-300 hover:text-primary transition-colors" href="#home">Inicio</a>
                <a class="text-sm font-medium text-slate-300 hover:text-primary transition-colors" href="#projects">Proyectos</a>
                <a class="text-sm font-medium text-slate-300 hover:text-primary transition-colors" href="#skills">Habilidades</a>
                <a class="text-sm font-medium text-slate-300 hover:text-primary transition-colors" href="#contact">Contacto</a>
            </div>
            <button class="bg-primary text-background-dark px-6 py-2.5 rounded font-bold text-sm hover:brightness-110 transition-all">
                Hablemos
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden" id="home">
        <!-- Abstract Background Glow -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] -z-10"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col lg:flex-row items-center gap-16">
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold uppercase tracking-widest mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Disponible para proyectos
                </div>
                <h1 class="text-5xl lg:text-7xl font-black text-white leading-[1.1] mb-8">
                    Construyendo <span class="text-primary">experiencias</span> digitales que importan
                </h1>
                <p class="text-lg lg:text-xl text-slate-400 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                    Somos un equipo de desarrollo full-stack especializado en aplicaciones web escalables e interfaces de usuario intuitivas que cierran la brecha entre la lógica compleja y un diseño hermoso.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a class="w-full sm:w-auto px-8 py-4 bg-primary text-background-dark rounded font-bold text-lg hover:shadow-[0_0_20px_rgba(13,185,242,0.4)] transition-all" href="#projects">
                        Ver Nuestro Trabajo
                    </a>
                    <a class="w-full sm:w-auto px-8 py-4 bg-transparent border border-slate-700 text-white rounded font-bold text-lg hover:bg-slate-800 transition-all" href="#contact">
                        Ponte en Contacto
                    </a>
                </div>
            </div>
            <div class="flex-1 w-full max-w-[500px]">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary to-blue-600 rounded-xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative aspect-square rounded-xl bg-slate-800 overflow-hidden border border-slate-700">
                        <img alt="Espacio de trabajo de desarrollador moderno con múltiples monitores y código" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700" data-alt="Modern developer workspace with multiple monitors and code" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD_wBqDGKbDh0JPTlI5UtvyVRmqu9R73H92GMUnn7yxYww0Y_uzbbWY9zgDcbucztSY5C9YJ74Xn80a8x-adbY_vewaMH4ihcylQDH7hCbG-SV0cNY15hIzMdD9X6gQtmt1vKut_YIGXDtQIf23WKTPJuYIc1Rm5-qUF_aaC44IWTbQdBoKv8YKonWhW9i8RI6eLoi-vqaX4i5DT7T2i6s0HxN96G1NAEKVaqe6KWCG5g9TNp-HXo_ZQXQ2nx8uq9TmOYuYRTy86g" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="py-24 bg-background-dark/50 border-y border-white/5" id="skills">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-4">Competencias Clave</h2>
                <h3 class="text-3xl lg:text-4xl font-extrabold text-white">Experiencia Técnica</h3>
            </div> 
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-8">
                <!-- Skill 1 -->
                <div class="skill-card flex flex-col items-center p-8 rounded-lg bg-slate-900/50 border border-slate-800 transition-all">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 text-primary">
                        <span class="material-symbols-outlined text-4xl">font_download</span>
                    </div>
                    <span class="text-white font-semibold">React</span>
                    <p class="text-slate-500 text-xs mt-2">Arquitectura frontend</p>
                </div>
                <!-- Skill 2 -->
                <div class="skill-card flex flex-col items-center p-8 rounded-lg bg-slate-900/50 border border-slate-800 transition-all">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 text-primary">
                        <span class="material-symbols-outlined text-4xl">terminal</span>
                    </div>
                    <span class="text-white font-semibold">Node.js</span>
                    <p class="text-slate-500 text-xs mt-2">Sistemas backend</p>
                </div>
                <!-- Skill 3 -->
                <div class="skill-card flex flex-col items-center p-8 rounded-lg bg-slate-900/50 border border-slate-800 transition-all">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 text-primary">
                        <span class="material-symbols-outlined text-4xl">integration_instructions</span>
                    </div>
                    <span class="text-white font-semibold">Python</span>
                    <p class="text-slate-500 text-xs mt-2">Datos y Automatización</p>
                </div>
                <!-- Skill 4 -->
                <div class="skill-card flex flex-col items-center p-8 rounded-lg bg-slate-900/50 border border-slate-800 transition-all">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 text-primary">
                        <span class="material-symbols-outlined text-4xl">cloud</span>
                    </div>
                    <span class="text-white font-semibold">AWS</span>
                    <p class="text-slate-500 text-xs mt-2">Infraestructura</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-24" id="projects">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-4">Portafolio</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-white">Proyectos Destacados</h3>
                </div>
                <p class="text-slate-400 max-w-md">
                    Una selección de mi trabajo más reciente, que abarca desde sistemas empresariales complejos hasta elegantes aplicaciones para consumidores.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Project Card 1 -->
                <div class="group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Interfaz de panel de control para una plataforma de análisis de datos" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" data-alt="Dashboard interface for a data analytics platform" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB88GwAREU8YLl0DV1-kqWrEz7d9Y0zkDg-JyQ_7SvldCPeiATQ1TIp8lfDCFqAM20Vrv33de9TzfSGM1ydLrZB_hcMeINYmaT027cLoglxNLSsB8uiMmf-HQBm0vBPmzNpPTGXJeAQYY659vV8NgRPTgl-di_evMUIQWE2sbUO96AyOQC_M1k_LyMnsnh8QJAzuvz4QQ_4iA4Awgkf6QWoyGanieLsEavS0szwxiXr41hnQtxCPk2khcqs0BTNv-HP7VSZGFRrbg" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">React</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Node</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Nebula Analytics</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Una plataforma de visualización de datos de alto rendimiento que procesa más de 1 millón de eventos por segundo con bucles de retroalimentación en tiempo real.
                        </p>
                        <a class="inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all" href="#">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <!-- Project Card 2 -->
                <div class="group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Aplicación móvil que muestra una interfaz de usuario de comercio electrónico moderna" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" data-alt="Mobile application showing modern e-commerce UI" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdPv0-TvPezYQMnnTNZWnKvAl4XzwzOYUoc4vIg9kO3LsK6TeMgFe6e4DNxtxbcI1JHK-qgAd97Wx4WSw0rScD7rnOCSC3rYQMTIUNegBwCj8cTB-G7XqLsdsssAgTpBsmqFy5wsYu8tTSZZ4siIYkFsuxjuYcLh61isUFSI-Vz9X-xa4F0Uo1s8VIf4sSctk6Q0j__G823nBFH9GM33M3ue2BBSProXA0J5s4iZ8ytHZ7eQ_CJ7fC0BipjYZyaf20ugUhxCc9yg" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">E-Commerce</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">NextJS</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Storefront Engine</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Solución de comercio headless moderna creada para escalar, con cargas de página en menos de un segundo e integración perfecta con Stripe.
                        </p>
                        <a class="inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all" href="#">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <!-- Project Card 3 -->
                <div class="group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Fragmentos de código sobre un fondo oscuro y limpio" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" data-alt="Code snippets on a clean dark background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBvWO7NzRoMGvwqxMX36VwO0V6BXOcPE89aaKBk3dyHypsg6R708lt5ixtUgJzRgPLc9gyuUoU-_EMceDJ_gz3WX6j4WEv3UDPKl92_62tTOP3YzaedH9aMhLYuJe7VEJsAzey1BVn1qNRZ82BpsPenznkXe4UI7CB9taODaui_lp2zaIjfKDe4n92577QLFdWqJ3KUWUJ_RRZF0gHFCJsJpGteALAw5pWY4NaFgP3hLe9t8etL8iGddlEyspq-pGOWCQv0ft1J7w" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">AWS</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">DevOps</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">Infrastructure Automator</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Herramienta CLI personalizada para automatizar la implementación de infraestructura de AWS, reduciendo el tiempo de aprovisionamiento en un 75% para los equipos de ingeniería.
                        </p>
                        <a class="inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all" href="#">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer / Contact -->
    <footer class="pt-24 pb-12 bg-background-dark border-t border-white/5" id="contact">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-20">
                <div>
                    <h3 class="text-4xl font-extrabold text-white mb-6">Construyamos algo excepcional juntos.</h3>
                    <p class="text-slate-400 text-lg mb-8 max-w-md">
                        Actualmente abierto a nuevas oportunidades y colaboraciones interesantes. No dudes en contactarme por correo electrónico o cualquier plataforma social.
                    </p>
                    <a class="text-2xl font-bold text-primary hover:underline underline-offset-8 transition-all" href="mailto:hello@devportfolio.com">
                        hola@devportfolio.com
                    </a>
                </div>
                <div class="flex flex-col justify-end">
                    <div class="flex gap-6">
                        <a class="w-12 h-12 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all" href="#">
                            <svg class="w-6 h-6 fill-current" viewbox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"></path>
                            </svg>
                        </a>
                        <a class="w-12 h-12 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all" href="#">
                            <svg class="w-6 h-6 fill-current" viewbox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"></path>
                            </svg>
                        </a>
                        <a class="w-12 h-12 rounded bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all" href="#">
                            <svg class="w-6 h-6 fill-current" viewbox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-sm">
                <p>© 2024 DevPortfolio. Todos los derechos reservados.</p>
                <div class="flex gap-8">
                    <a class="hover:text-white transition-colors" href="#">Política de Privacidad</a>
                    <a class="hover:text-white transition-colors" href="#">Términos de Servicio</a>
                </div>
            </div>
        </div>
    </footer>
    <?php require 'chatbot.php'; ?>
</body>

</html>