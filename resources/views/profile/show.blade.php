<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - TechShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen">
<!-- Navigation -->
<nav class="bg-black/30 backdrop-blur-md fixed w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo et nom du site -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <span class="text-2xl font-bold gradient-text">TechShop</span>
            </a>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-white hover:text-blue-400 transition-colors flex items-center">
                    <i class="fas fa-home mr-2"></i> Accueil
                </a>
                <a href="#" class="text-white hover:text-blue-400 transition-colors flex items-center">
                    <i class="fas fa-laptop mr-2"></i> Produits
                </a>
                <a href="#" class="text-white hover:text-blue-400 transition-colors flex items-center">
                    <i class="fas fa-tags mr-2"></i> Promotions
                </a>
            </div>

            <!-- Boutons Auth et Panier -->
            <div class="flex items-center space-x-6">
                <a href="#" class="text-white hover:text-blue-400 transition-colors relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-blue-600 text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>

                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('profile.show') }}" class="text-white hover:text-blue-400 transition-colors flex items-center">
                            <i class="fas fa-user mr-2"></i> {{ Auth::user()->name }}
                        </a>
                        <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-xl transition-colors flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </a>

                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-white hover:text-blue-400 transition-colors">Connexion</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all transform hover:scale-105">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Menu mobile -->
<div class="md:hidden bg-gray-900 fixed bottom-0 left-0 right-0 z-50 border-t border-gray-800">
    <div class="flex justify-around py-3">
        <a href="{{ route('home') }}" class="text-white hover:text-blue-400 transition-colors">
            <i class="fas fa-home text-xl"></i>
        </a>
        <a href="#" class="text-white hover:text-blue-400 transition-colors">
            <i class="fas fa-laptop text-xl"></i>
        </a>
        <a href="#" class="text-white hover:text-blue-400 transition-colors">
            <i class="fas fa-shopping-cart text-xl"></i>
        </a>
        <a href="{{ route('profile.show') }}" class="text-white hover:text-blue-400 transition-colors">
            <i class="fas fa-user text-xl"></i>
        </a>
    </div>
</div>

<div class="container mx-auto px-4 pt-32 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar avec informations utilisateur -->
        <div class="lg:col-span-1">
            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-8 card-hover">
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mb-4">
                        <span class="text-4xl font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <h2 class="text-2xl font-bold gradient-text">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-400">{{ auth()->user()->email }}</p>
                    <div class="mt-6 w-full">
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl mb-4">
                            <span>Membre depuis</span>
                            <span class="text-blue-400">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                            <span>Commandes totales</span>
                            <span class="text-blue-400">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mini Panier -->
            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-8 mt-8 card-hover">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-shopping-cart mr-2 text-blue-500"></i>
                    Mon Panier
                </h3>
                <div class="space-y-4">
                    <!-- Exemple d'articles dans le panier -->
                    <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-700 rounded-lg mr-3"></div>
                            <div>
                                <p class="font-medium">Produit Example</p>
                                <p class="text-sm text-gray-400">Quantité: 1</p>
                            </div>
                        </div>
                        <span class="text-blue-400">299.99 €</span>
                    </div>
                    <a href="#" class="block text-center py-3 bg-blue-600 hover:bg-blue-700 rounded-xl transition duration-300">
                        Voir mon panier complet
                    </a>
                </div>
            </div>
        </div>

        <!-- Section principale -->
        <div class="lg:col-span-2">
            <!-- Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500 rounded-xl flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire de profil -->
            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-8 card-hover">
                <h1 class="text-3xl font-bold mb-8 gradient-text flex items-center">
                    <i class="fas fa-user-circle mr-3"></i>
                    Informations personnelles
                </h1>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-user mr-2"></i>Nom
                            </label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}"
                                   class="w-full px-4 py-3 rounded-xl bg-gray-800/50 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                   class="w-full px-4 py-3 rounded-xl bg-gray-800/50 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-6 mt-6">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-lock mr-2"></i>
                            Changer le mot de passe
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password"
                                       class="w-full px-4 py-3 rounded-xl bg-gray-800/50 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Nouveau mot de passe</label>
                                    <input type="password" name="new_password"
                                           class="w-full px-4 py-3 rounded-xl bg-gray-800/50 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Confirmer le mot de passe</label>
                                    <input type="password" name="new_password_confirmation"
                                           class="w-full px-4 py-3 rounded-xl bg-gray-800/50 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl transition-all transform hover:scale-105 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
