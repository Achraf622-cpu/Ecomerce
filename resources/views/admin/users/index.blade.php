@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Liste des Utilisateurs</h3>

            <div class="flex space-x-4">
                <div class="relative">
                    <input type="text"
                           id="search"
                           placeholder="Rechercher..."
                           class="rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <button onclick="performSearch()"
                            class="absolute right-0 top-0 h-full px-3 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>

                <select id="role-filter" class="rounded-md border-gray-300" onchange="updateFilters()">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="user">Utilisateur</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscrit le</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <span class="text-xl font-medium text-gray-600">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                       {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                       {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $user->email_verified_at ? 'Vérifié' : 'Non vérifié' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-blue-600 hover:text-blue-900 mr-4">
                                Modifier
                            </a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Supprimer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            function updateFilters() {
                const role = document.getElementById('role-filter').value;

                let url = new URL(window.location.href);
                if (role) url.searchParams.set('role', role);
                else url.searchParams.delete('role');

                window.location.href = url.toString();
            }

            function performSearch() {
                const search = document.getElementById('search').value;

                let url = new URL(window.location.href);
                if (search) url.searchParams.set('search', search);
                else url.searchParams.delete('search');

                window.location.href = url.toString();
            }
        </script>
    @endpush
@endsection
