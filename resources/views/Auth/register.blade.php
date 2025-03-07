<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - TechShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-border {
            position: relative;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            padding: 1px;
            border-radius: 0.75rem;
        }
        .gradient-border-content {
            background: rgba(17, 24, 39, 0.8);
            border-radius: 0.7rem;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-900 to-gray-800 min-h-screen flex flex-col">
<!-- Navigation -->
<nav class="bg-black/30 backdrop-blur-md w-full z-50 mb-8">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="/" class="text-3xl font-bold gradient-text">
                TechShop
            </a>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="flex-1 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <div class="gradient-border">
            <div class="gradient-border-content p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold gradient-text mb-2">Inscription</h2>
                    <p class="text-gray-400">Créez votre compte TechShop</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nom</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 rounded-lg bg-gray-800/50 border {{ isset($errors) && $errors->has('name') ? 'border-red-500' : 'border-gray-700' }} text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                               placeholder="Votre nom"
                               required>
                        @if(isset($errors) && $errors->has('name'))
                            <p class="mt-1.5 text-sm text-red-400">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 rounded-lg bg-gray-800/50 border {{ isset($errors) && $errors->has('email') ? 'border-red-500' : 'border-gray-700' }} text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                               placeholder="votreemail@exemple.com"
                               required>
                        @if(isset($errors) && $errors->has('email'))
                            <p class="mt-1.5 text-sm text-red-400">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Mot de passe</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 rounded-lg bg-gray-800/50 border {{ isset($errors) && $errors->has('password') ? 'border-red-500' : 'border-gray-700' }} text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                               placeholder="••••••••"
                               required>
                        @if(isset($errors) && $errors->has('password'))
                            <p class="mt-1.5 text-sm text-red-400">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-3 rounded-lg bg-gray-800/50 border border-gray-700 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors"
                               placeholder="••••••••"
                               required>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                        S'inscrire
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <span class="text-gray-400">Déjà inscrit ?</span>
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium ml-1">
                        Connectez-vous
                    </a>
                </div>
            </div>
        </div>

        <!-- Particules en arrière-plan -->
        <div id="particles-js" class="fixed inset-0 -z-10"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
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
</script>
</body>
</html>
