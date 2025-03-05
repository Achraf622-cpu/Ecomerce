@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold">Liste des Commandes</h3>

            <!-- Filtres -->
            <div class="flex space-x-4">
                <select id="status-filter" class="rounded-md border-gray-300" onchange="updateFilters()">
                    <option value="">Tous les statuts</option>
                    <option value="PENDING">En attente</option>
                    <option value="PROCESSING">En traitement</option>
                    <option value="SHIPPED">Expédiée</option>
                    <option value="DELIVERED">Livrée</option>
                    <option value="CANCELLED">Annulée</option>
                </select>

                <input type="date" id="date-filter" class="rounded-md border-gray-300" onchange="updateFilters()">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <div>{{ $order->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">{{ number_format($order->total, 2) }} €</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                       {{ $order->status === 'DELIVERED' ? 'bg-green-100 text-green-800' :
                                          ($order->status === 'CANCELLED' ? 'bg-red-100 text-red-800' :
                                          'bg-yellow-100 text-yellow-800') }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-blue-600 hover:text-blue-900 mr-4">
                                Détails
                            </a>

                            @if($order->status !== 'CANCELLED' && $order->status !== 'DELIVERED')
                                <form action="{{ route('admin.orders.update-status', $order) }}"
                                      method="POST"
                                      class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-sm border-gray-300 rounded-md">
                                        <option value="PENDING" {{ $order->status === 'PENDING' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="PROCESSING" {{ $order->status === 'PROCESSING' ? 'selected' : '' }}>
                                            En traitement
                                        </option>
                                        <option value="SHIPPED" {{ $order->status === 'SHIPPED' ? 'selected' : '' }}>
                                            Expédiée
                                        </option>
                                        <option value="DELIVERED" {{ $order->status === 'DELIVERED' ? 'selected' : '' }}>
                                            Livrée
                                        </option>
                                        <option value="CANCELLED" {{ $order->status === 'CANCELLED' ? 'selected' : '' }}>
                                            Annulée
                                        </option>
                                    </select>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            function updateFilters() {
                const status = document.getElementById('status-filter').value;
                const date = document.getElementById('date-filter').value;

                let url = new URL(window.location.href);
                if (status) url.searchParams.set('status', status);
                else url.searchParams.delete('status');

                if (date) url.searchParams.set('date', date);
                else url.searchParams.delete('date');

                window.location.href = url.toString();
            }
        </script>
    @endpush
@endsection
