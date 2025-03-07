<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop - Votre Boutique High-Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 1s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out;
        }

        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white">
<!-- Hero Section avec Animation -->
<div class="relative min-h-screen">
    <!-- Particules animées en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden">
        <div id="particles-js" class="absolute inset-0"></div>
    </div>

    <!-- Contenu Principal -->
    <div class="relative z-10">
        <!-- Navigation -->
        <nav class="bg-black/30 backdrop-blur-md fixed w-full z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-4">
                        <div class="text-3xl font-bold gradient-text">
                            TechShop
                        </div>
                    </div>

                    <!-- Menu principal -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="relative group">
                            <span class="text-white hover:text-blue-400 transition-colors py-2">Accueil</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                        </a>
                        <a href="#" class="relative group">
                            <span class="text-white hover:text-blue-400 transition-colors py-2">Produits</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                        </a>
                        <a href="#" class="relative group">
                            <span class="text-white hover:text-blue-400 transition-colors py-2">Catégories</span>
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                        </a>
                    </div>

                    <!-- Boutons Auth -->
                    <!-- Boutons Auth -->
                    <div class="flex items-center space-x-4">
                        @if(auth()->check())
                            <a href="{{ route('profile.show') }}" class="px-4 py-2 text-white hover:text-blue-400 transition-colors">
                                Mon Profil
                            </a>
                            <a href="{{ route('logout') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition-all transform hover:scale-105">
                                Déconnexion
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-white hover:text-blue-400 transition-colors">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-all transform hover:scale-105">
                                Inscription
                            </a>
                        @endif
                    </div>

                    <!-- Menu Mobile (hamburger) -->
                    <div class="md:hidden">
                        <button class="text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile (contenu) -->
            <div class="md:hidden hidden">
                <div class="px-4 py-3 space-y-3">
                    <a href="#" class="block text-white hover:text-blue-400 transition-colors">Accueil</a>
                    <a href="#" class="block text-white hover:text-blue-400 transition-colors">Produits</a>
                    <a href="#" class="block text-white hover:text-blue-400 transition-colors">Catégories</a>
                    <div class="pt-4 border-t border-gray-700">
                        <a href="{{ route('login') }}" class="block text-white hover:text-blue-400 transition-colors py-2">Connexion</a>
                        <a href="{{ route('register') }}" class="block text-white hover:text-blue-400 transition-colors py-2">Inscription</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container mx-auto px-6 pt-32 pb-20">
            <div class="flex flex-col items-center justify-center min-h-[80vh] text-center">
                <h1 class="text-6xl md:text-8xl font-bold mb-8 animate-fade-in-down gradient-text">
                    Bienvenue dans le Futur
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl animate-fade-in-up">
                    Découvrez notre collection exclusive de produits high-tech et plongez dans un univers d'innovation
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 rounded-full transition-all transform hover:scale-105">
                        Explorer
                    </a>
                    <a href="#" class="px-8 py-4 border border-blue-600 rounded-full hover:bg-blue-600/20 transition-all transform hover:scale-105">
                        En savoir plus
                    </a>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20">
                <!-- Card 1 -->
                <div class="bg-black/30 backdrop-blur-md p-6 rounded-xl hover:transform hover:scale-105 transition-all">
                    <div class="text-blue-500 text-4xl mb-4">🚀</div>
                    <h3 class="text-xl font-bold mb-2">Innovation</h3>
                    <p class="text-gray-400">Les dernières technologies à portée de main.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-black/30 backdrop-blur-md p-6 rounded-xl hover:transform hover:scale-105 transition-all">
                    <div class="text-blue-500 text-4xl mb-4">💎</div>
                    <h3 class="text-xl font-bold mb-2">Qualité</h3>
                    <p class="text-gray-400">Des produits sélectionnés avec soin.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-black/30 backdrop-blur-md p-6 rounded-xl hover:transform hover:scale-105 transition-all">
                    <div class="text-blue-500 text-4xl mb-4">🎯</div>
                    <h3 class="text-xl font-bold mb-2">Service</h3>
                    <p class="text-gray-400">Un support client disponible 24/7.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                }
            },
            retina_detect: true
        });
    });
</script>
</body>
</html>
