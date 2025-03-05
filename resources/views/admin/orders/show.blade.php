@extends('layouts.admin')

@section('title', 'Détails de la Commande #' . $order->order_number)

@section('content')
    <div class="space-y-6">
        <!-- Informations de la commande -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Informations de la commande</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Numéro de commande</p>
                            <p class="font-medium">#{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Statut</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                   {{ $order->status === 'DELIVERED' ? 'bg-green-100 text-green-800' :
                                      ($order->status === 'CANCELLED' ? 'bg-red-100 text-red-800' :
                                      'bg-yellow-100 text-yellow-800') }}">
                            {{ $order->status }}
                        </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="font-medium">{{ number_format($order->total, 2) }} €</p>
                        </div>
                    </div>
                </div>

                @if($order->status !== 'CANCELLED' && $order->status !== 'DELIVERED')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                                class="border-gray-300 rounded-md">
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
            </div>
        </div>

        <!-- Informations client -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Informations client</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nom</p>
                    <p class="font-medium">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Téléphone</p>
                    <p class="font-medium">{{ $order->shipping_phone }}</p>
                </div>
            </div>
        </div>

        <!-- Adresse de livraison -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Adresse de livraison</h3>
            <p>{{ $order->shipping_address }}</p>
            <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
            <p>{{ $order->shipping_country }}</p>
        </div>

        <!-- Articles de la commande -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Articles commandés</h3>
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="h-10 w-10 object-cover rounded">
                                @endif
                                <div class="ml-4">
                                    <div>{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ number_format($item->price, 2) }} €</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">{{ number_format($item->price * $item->quantity, 2) }} €</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-4 text-right font-medium">Total</td>
                    <td class="px-6 py-4 font-bold">{{ number_format($order->total, 2) }} €</td>
                </tr>
                </tfoot>
            </table>
        </div>

        <!-- Historique des changements de statut -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Historique des statuts</h3>
            <div class="space-y-4">
                @foreach($order->statusHistory as $history)
                    <div class="flex justify-between items-center">
                        <div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                   {{ $history->status === 'DELIVERED' ? 'bg-green-100 text-green-800' :
                                      ($history->status === 'CANCELLED' ? 'bg-red-100 text-red-800' :
                                      'bg-yellow-100 text-yellow-800') }}">
                            {{ $history->status }}
                        </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $history->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.orders.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Retour à la liste
            </a>

            @if($order->status !== 'CANCELLED')
                <form action="{{ route('admin.orders.cancel', $order) }}"
                      method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Annuler la commande
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
