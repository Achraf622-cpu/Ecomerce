<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - TechShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-900 to-gray-800 text-white min-h-screen">
<!-- Navigation (même que welcome.blade.php) -->
<nav class="bg-black/30 backdrop-blur-md fixed w-full z-50">
    <!-- ... copiez la navigation de welcome.blade.php ... -->
</nav>

<div class="container mx-auto px-6 pt-32 pb-20">
    <div class="max-w-2xl mx-auto">
        <!-- Messages d'erreur/succès -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-500/20 border border-green-500 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-500/20 border border-red-500 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Carte de profil -->
        <div class="bg-black/30 backdrop-blur-md rounded-xl p-8 mb-8">
            <h1 class="text-3xl font-bold mb-6 gradient-text">Mon Profil</h1>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                <!-- Informations de base -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nom</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                               class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
                               class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white">
                    </div>

                    <!-- Changement de mot de passe -->
                    <div class="pt-6 border-t border-gray-700">
                        <h2 class="text-xl font-semibold mb-4">Changer le mot de passe</h2>

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" id="current_password"
                                       class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white">
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-300 mb-2">Nouveau mot de passe</label>
                                <input type="password" name="new_password" id="new_password"
                                       class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white">
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                       class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-full transition-all transform hover:scale-105">
                            Mettre à jour le profil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
