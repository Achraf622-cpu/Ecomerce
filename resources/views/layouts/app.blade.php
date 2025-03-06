<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">
<!-- Navigation -->
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-xl font-bold">{{ config('app.name') }}</span>
                </a>
                <div class="hidden sm:ml-6 sm:flex space-x-8">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-900">
                        Produits
                    </a>
                    @auth
                        <a href="{{ route('cart.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-900">
                            Panier
                        </a>
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-900">
                            Mes Commandes
                        </a>
                    @endauth
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                            @if(Auth::user()->role === 'ADMIN')
                                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Administration
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700 px-3 py-2">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700 px-3 py-2">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg">
        {{ session('error') }}
    </div>
@endif

<main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @yield('content')
</main>

<footer class="bg-white shadow-inner mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4">
        <div class="text-center text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</footer>
</body>
</html>
