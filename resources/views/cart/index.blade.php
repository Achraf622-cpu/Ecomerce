@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Mon Panier</h1>

        @if($cart->items->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full">
                    <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Produit</th>
                        <th class="text-center py-2">Prix unitaire</th>
                        <th class="text-center py-2">Quantité</th>
                        <th class="text-center py-2">Total</th>
                        <th class="text-right py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart->items as $item)
                        <tr class="border-b">
                            <td class="py-4">
                                <div class="flex items-center">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-16 h-16 object-cover rounded">
                                    @endif
                                    <span class="ml-4">{{ $item->product->name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ number_format($item->product->price, 2) }} €</td>
                            <td class="text-center">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <select name="quantity" onchange="this.form.submit()"
                                            class="rounded border-gray-300">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </form>
                            </td>
                            <td class="text-center">
                                {{ number_format($item->product->price * $item->quantity, 2) }} €
                            </td>
                            <td class="text-right">
                                <form action="{{ route('cart.remove', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-right py-4">Total :</td>
                        <td class="text-center py-4 font-bold">
                            {{ number_format($cart->getTotal(), 2) }} €
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>

                <div class="mt-6 flex justify-between">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Vider le panier
                        </button>
                    </form>

                    <a href="{{ route('orders.create') }}"
                       class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Passer la commande
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600">Votre panier est vide.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Continuer les achats
                </a>
            </div>
        @endif
    </div>
@endsection
