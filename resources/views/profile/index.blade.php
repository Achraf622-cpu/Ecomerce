@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Mon Profil</h1>

            <div class="mb-4">
                <label class="font-bold">Nom :</label>
                <p>{{ Auth::user()->name }}</p>
            </div>

            <div class="mb-4">
                <label class="font-bold">Email :</label>
                <p>{{ Auth::user()->email }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Modifier le profil
                </a>
            </div>
        </div>
    </div>
@endsection
