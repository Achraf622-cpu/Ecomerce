<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MegaShop - Votre boutique en ligne</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
<!-- En-tête -->
<header class="bg-white shadow-md">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">MegaShop</a>
            </div>

            <!-- Menu de navigation -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-indigo-600">Produits</a>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-indigo-600">Catégories</a>
                <a href="#" class="text-gray-600 hover:text-indigo-600">Promotions</a>
            </div>

            <!-- Menu utilisateur -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-indigo-600">
                        <span class="relative">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if(Cart::count() > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs">
                                    {{ Cart::count() }}
                                </span>
                            @endif
                        </span>
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes commandes</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- Bannière principale -->
<section class="bg-indigo-600 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Découvrez notre collection exclusive</h1>
            <p class="text-xl mb-8">Les meilleures offres pour tous vos besoins, livrées directement chez vous.</p>
            <a href="{{ route('products.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-md font-semibold hover:bg-gray-100 inline-block">
                Voir nos produits
            </a>
        </div>
    </div>
</section>

<!-- Catégories populaires -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Catégories populaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group">
                    <div class="relative overflow-hidden rounded-lg shadow-lg">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                             class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <h3 class="text-white text-xl font-semibold">{{ $category->name }}</h3>
                            <p class="text-white/80">{{ $category->products_count }} produits</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Produits en vedette -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Produits en vedette</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-indigo-600">{{ number_format($product->price, 2) }} €</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                                    onclick="window.location.href='{{ route('cart.add', $product) }}'">
                                Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Avantages -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                    <svg class="h-8 w-8 text-indigo-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Livraison gratuite</h3>
                <p class="text-gray-600">Pour toute commande supérieure à 50€</p>
            </div>

            <div class="text-center">
                <div class="bg-indigo-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                    <svg class="h-8 w-8 text-indigo-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Service 24/7</h3>
                <p class="text-gray-600">Support client disponible à tout moment</p>
            </div>

            <div class="text-center">
                <div class="bg-indigo-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                    <svg class="h-8 w-8 text-indigo-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Paiement sécurisé</h3>
                <p class="text-gray-600">Transactions 100% sécurisées</p>
            </div>
        </div>
    </div>
</section>

<!-- Pied de page -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h4 class="text-lg font-semibold mb-4">À propos</h4>
                <p class="text-gray-400">MegaShop est votre destination shopping en ligne pour tous vos besoins.</p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Livraison</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Retours</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: contact@megashop.fr</li>
                    <li>Tél: 01 23 45 67 89</li>
                    <li>Adresse: 123 Rue du Commerce</li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
                <form class="flex">
                    <input type="email" placeholder="Votre email"
                           class="flex-1 px-4 py-2 rounded-l-md text-gray-900 focus:outline-none">
                    <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-r-md hover:bg-indigo-700">
                        S'inscrire
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} MegaShop. Tous droits réservés.</p>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
