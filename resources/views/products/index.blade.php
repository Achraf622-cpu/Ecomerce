@extends('layouts.app')

@section('title', 'Nos Produits')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Nos Produits</h1>
            <div class="flex space-x-4">
                <!-- Filtres -->
                <select class="rounded-md border-gray-300" onchange="window.location.href=this.value">
                    <option value="{{ route('products.index') }}">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ route('products.index', ['category' => $category->slug]) }}"
                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">Pas d'image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">{{ number_format($product->price, 2) }} €</span>
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Ajouter au panier
                                    </button>
                                </form>
                            @else
                                <span class="text-red-500">Rupture de stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
