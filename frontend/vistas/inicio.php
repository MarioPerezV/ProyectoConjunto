<!DOCTYPE html>

<html class="dark" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Maquina Virtual | Desarrollador de Software de Alta Gama</title>
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

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .animate-fade-in-up { animation: fade-in-up 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
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
                <h1 class="text-white">MAQUINA<span class="text-xl font-bold tracking-tight text-primary"> VIRTUAL</span> spa</h1>
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
                    Construyendo <span class="text-primary">ACTIVOS</span> digitales
                </h1>
                <p class="text-lg lg:text-xl text-slate-400 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                    Somos un equipo de desarrollo full-stack y automatización IA, especializado en aplicaciones web escalables e interfaces de usuario intuitivas que cierran la brecha entre la lógica compleja y un diseño atractivo.
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
    <!-- Projects Section -->
    <section class="py-24" id="projects">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-primary font-bold tracking-widest uppercase text-sm mb-4">Portafolio</h2>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-white">Proyectos Destacados</h3>
                </div>
                <p class="text-slate-400 max-w-md">
                    Una selección de nuestro trabajo más reciente, que abarca desde sistemas empresariales complejos hasta elegantes aplicaciones para consumidores.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">                
                <!-- Project Card 1: MitigaRiesgo.cl -->
                <div class="project-card group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col" 
                    data-title="MitigaRiesgo.cl"
                    data-description="Consultoría especializada en la implementación de Sistemas de Gestión de Seguridad y Salud en el Trabajo (SGSST). Ayudamos a las empresas a cumplir con la Ley 16.744, reduciendo la accidentabilidad y mejorando la productividad."
                    data-image="https://images.unsplash.com/photo-1581092921461-e760b1e393ab?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    data-tags='["Consultoría", "SGSST", "WordPress"]'
                    data-url="https://mitigariesgo.cl">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Proyecto MitigaRiesgo.cl" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1581092921461-e760b1e393ab?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Consultoría</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">SGSST</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">MitigaRiesgo.cl</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Consultoría en implementación de Sistemas de Gestión de Seguridad y Salud en el Trabajo (SGSST) para empresas.
                        </p>
                        <button class="open-project-modal inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all text-left">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Project Card 2: AgenciaGaby.com -->
                <div class="project-card group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col"
                    data-title="AgenciaGaby.com"
                    data-description="Agencia de Diseño Web con Sistemas de Gestión en tiempo real que potencia la presencia online de negocios y emprendimientos."
                    data-image="https://images.unsplash.com/photo-1557862921-37829c790f19?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    data-tags='["Sistemas de Gestión", "Desarrollo Web"]'
                    data-url="https://agenciagaby.com"
                    data-video-url="https://www.youtube.com/embed/EHNSFUIPL_4">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Proyecto AgenciaGaby.com" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1557862921-37829c790f19?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Sistemas de Gestión</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Desarrollo Web</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">AgenciaGaby.com</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Agencia de Diseño Web con Sistemas de Gestión en tiempo real que potencia la presencia online de negocios y emprendimientos.
                        </p>
                        <button class="open-project-modal inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all text-left">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Project Card 3: LaSerenaDenuncia.cl -->
                <div class="project-card group bg-slate-900/30 rounded-xl overflow-hidden border border-slate-800 hover:border-primary/50 transition-all flex flex-col"
                    data-title="LaSerenaDenuncia.cl"
                    data-description="Plataforma ciudadana para la comuna de La Serena. Permite a los vecinos reportar incidencias y problemas en la vía pública, fomentando la participación y colaborando con la gestión municipal para una ciudad más segura y limpia."
                    data-image="https://images.unsplash.com/photo-1549877452-9c3e87a491a1?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    data-tags='["Plataforma Ciudadana", "Participación", "Laravel"]'
                    data-url="https://laserenadenuncia.cl">
                    <div class="aspect-video relative overflow-hidden">
                        <img alt="Proyecto LaSerenaDenuncia.cl" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1549877452-9c3e87a491a1?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
                        <div class="absolute inset-0 bg-background-dark/40 group-hover:bg-background-dark/10 transition-colors"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Plataforma Ciudadana</span>
                            <span class="text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter">Laravel</span>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-3">LaSerenaDenuncia.cl</h4>
                        <p class="text-slate-400 text-sm mb-6 flex-1">
                            Plataforma ciudadana para reportar incidencias en La Serena, fomentando la participación y mejorando la gestión municipal.
                        </p>
                        <button class="open-project-modal inline-flex items-center gap-2 text-primary text-sm font-bold hover:gap-3 transition-all text-left">
                            Ver Proyecto <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
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

    <!-- Project Modal -->
    <div id="project-modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[1100] hidden items-center justify-center p-4" style="display: none;">
        <div id="project-modal-content" class="bg-slate-900/95 border border-primary/20 rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col animate-fade-in-up">
            <!-- Header -->
            <div class="flex justify-between items-center p-4 border-b border-slate-800 shrink-0">
                <h3 id="modal-title" class="text-xl font-bold text-white"></h3>
                <button id="close-modal-button" class="p-2 text-slate-400 hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Body -->
            <div class="p-6 md:p-8 overflow-y-auto flex-grow">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="aspect-video">
                        <div id="modal-media-image" class="w-full h-full">
                            <img id="modal-image" src="" alt="Vista previa del proyecto" class="rounded-lg w-full h-full object-cover border border-slate-700">
                        </div>
                        <div id="modal-media-video" class="w-full h-full hidden">
                            <iframe id="modal-video" class="rounded-lg w-full h-full border border-slate-700" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div id="modal-tags" class="flex flex-wrap gap-2 mb-4">
                            <!-- Tags will be injected here -->
                        </div>
                        <p id="modal-description" class="text-slate-300 mb-6 flex-grow"></p>
                        <a id="modal-url" href="#" target="_blank" rel="noopener noreferrer" class="mt-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-background-dark rounded font-bold hover:shadow-[0_0_20px_rgba(13,185,242,0.4)] transition-all">
                            Visitar Sitio Web
                            <span class="material-symbols-outlined text-base">open_in_new</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'chatbot.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('project-modal');
        const closeModalButton = document.getElementById('close-modal-button');
        const openModalButtons = document.querySelectorAll('.open-project-modal');
        if (!modal || !closeModalButton || openModalButtons.length === 0) return;

        const modalTitle = document.getElementById('modal-title');        
        const modalDescription = document.getElementById('modal-description');        
        const modalTags = document.getElementById('modal-tags');        
        const modalUrl = document.getElementById('modal-url');
        const modalImageContainer = document.getElementById('modal-media-image');
        const modalImage = document.getElementById('modal-image');
        const modalVideoContainer = document.getElementById('modal-media-video');
        const modalVideo = document.getElementById('modal-video');

        const openModal = (projectCard) => {
            const data = projectCard.dataset;
            modalTitle.textContent = data.title;
            modalDescription.textContent = data.description;
            modalUrl.href = data.url;

            if (data.videoUrl) {
                modalImageContainer.classList.add('hidden');
                modalVideoContainer.classList.remove('hidden');
                modalVideo.src = data.videoUrl;
            } else {
                modalVideoContainer.classList.add('hidden');
                modalImageContainer.classList.remove('hidden');
                modalImage.src = data.image;
                modalImage.alt = `Vista previa del proyecto ${data.title}`;
            }

            modalTags.innerHTML = '';
            try {
                JSON.parse(data.tags).forEach(tag => {
                    const tagEl = document.createElement('span');
                    tagEl.className = 'text-[10px] font-bold px-2 py-1 bg-slate-800 rounded text-slate-400 uppercase tracking-tighter';
                    tagEl.textContent = tag;
                    modalTags.appendChild(tagEl);
                });
            } catch (e) { console.error('Error parsing tags JSON:', e); }
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        const closeModal = () => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            // Detener el video al cerrar el modal para evitar que se reproduzca en segundo plano
            modalVideo.src = '';
        };

        openModalButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const projectCard = button.closest('.project-card');
                if (projectCard) openModal(projectCard);
            });
        });

        closeModalButton.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && modal.style.display === 'flex') closeModal(); });
    });
    </script>
</body>

</html>