@extends('layouts.admin')

@section('title', isset($category) ? 'Modifier la Catégorie' : 'Nouvelle Catégorie')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
              method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    {{ isset($category) ? 'Mettre à jour' : 'Créer' }}
                </button>
            </div>
        </form>
    </div>
@endsection
