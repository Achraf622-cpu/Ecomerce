@extends('layouts.admin')

@section('title', 'Gestion des Avis')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Liste des Avis Clients</h3>

            <!-- Filtres -->
            <div class="flex space-x-4">
                <select id="status-filter" class="rounded-md border-gray-300" onchange="updateFilters()">
                    <option value="">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="approved">Approuvé</option>
                    <option value="rejected">Rejeté</option>
                </select>

                <select id="rating-filter" class="rounded-md border-gray-300" onchange="updateFilters()">
                    <option value="">Toutes les notes</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} étoile(s)</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reviews as $review)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($review->product->image)
                                    <img src="{{ Storage::url($review->product->image) }}"
                                         alt="{{ $review->product->name }}"
                                         class="h-10 w-10 object-cover rounded">
                                @endif
                                <span class="ml-2">{{ $review->product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $review->user->name }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="line-clamp-2">{{ $review->comment }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                       {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' :
                                          ($review->status === 'rejected' ? 'bg-red-100 text-red-800' :
                                          'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openReviewModal({{ $review->id }})"
                                    class="text-blue-600 hover:text-blue-900 mr-4">
                                Détails
                            </button>

                            @if($review->status === 'pending')
                                <form action="{{ route('admin.reviews.update-status', $review) }}"
                                      method="POST"
                                      class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            name="status"
                                            value="approved"
                                            class="text-green-600 hover:text-green-900 mr-4">
                                        Approuver
                                    </button>
                                    <button type="submit"
                                            name="status"
                                            value="rejected"
                                            class="text-red-600 hover:text-red-900">
                                        Rejeter
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
            {{ $reviews->links() }}
        </div>
    </div>

    <!-- Modal Détails Avis -->
    <div id="review-modal" class="fixed z-10 inset-0 hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Détails de l'avis
                            </h3>
                            <div class="mt-4 space-y-4" id="review-details">
                                <!-- Le contenu sera injecté dynamiquement -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            onclick="closeReviewModal()">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateFilters() {
                const status = document.getElementById('status-filter').value;
                const rating = document.getElementById('rating-filter').value;

                let url = new URL(window.location.href);
                if (status) url.searchParams.set('status', status);
                else url.searchParams.delete('status');

                if (rating) url.searchParams.set('rating', rating);
                else url.searchParams.delete('rating');

                window.location.href = url.toString();
            }

            function openReviewModal(reviewId) {
                // Implémentez la logique pour charger les détails de l'avis via AJAX
                fetch(`/admin/reviews/${reviewId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('review-details').innerHTML = `
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Client</h4>
                        <p class="mt-1">${data.user.name}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Produit</h4>
                        <p class="mt-1">${data.product.name}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Note</h4>
                        <div class="flex items-center mt-1">
                            ${Array(5).fill().map((_, i) => `
                                <svg class="h-5 w-5 ${i < data.rating ? 'text-yellow-400' : 'text-gray-300'}"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            `).join('')}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Commentaire</h4>
                        <p class="mt-1">${data.comment}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Date</h4>
                        <p class="mt-1">${new Date(data.created_at).toLocaleDateString()}</p>
                    </div>
                </div>
            `;
                        document.getElementById('review-modal').classList.remove('hidden');
                    });
            }

            function closeReviewModal() {
                document.getElementById('review-modal').classList.add('hidden');
            }
        </script>
    @endpush
@endsection
