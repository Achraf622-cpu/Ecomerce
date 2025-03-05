@extends('layouts.admin')

@section('title', isset($product) ? 'Modifier le Produit' : 'Nouveau Produit')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="category_id" id="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              required>{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="price" id="price" step="0.01" min="0"
                               class="block w-full pr-12 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('price', $product->price ?? '') }}" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">€</span>
                        </div>
                    </div>
                    @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('stock', $product->stock ?? '') }}" required>
                    @error('stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="ACTIVE" {{ (old('status', $product->status ?? '') == 'ACTIVE') ? 'selected' : '' }}>
                            Actif
                        </option>
                        <option value="INACTIVE" {{ (old('status', $product->status ?? '') == 'INACTIVE') ? 'selected' : '' }}>
                            Inactif
                        </option>
                        <option value="OUT_OF_STOCK" {{ (old('status', $product->status ?? '') == 'OUT_OF_STOCK') ? 'selected' : '' }}>
                            Rupture de stock
                        </option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                    @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="Current image"
                                 class="h-32 w-32 object-cover rounded">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    {{ isset($product) ? 'Mettre à jour' : 'Créer' }}
                </button>
            </div>
        </form>
    </div>
@endsection
