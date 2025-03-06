<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 px-2 py-4 flex-shrink-0">
        <div class="mb-8">
            <h1 class="text-2xl font-bold px-4">Administration</h1>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.products.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                📦 Produits
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                📁 Catégories
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                🛒 Commandes
            </a>
            <a href="{{ route('admin.reviews.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-700' : '' }}">
                ⭐ Avis
            </a>
            <div class="border-t border-gray-600 my-4"></div>
            <a href="{{ route('home') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                🏠 Retour au site
            </a>
        </nav>
    </div>

    <!-- Content -->
    <div class="flex-1">
        <!-- Top bar -->
        <header class="bg-white shadow">
            <div class="flex justify-between items-center px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-4">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Notifications -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
