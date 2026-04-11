@extends('layouts.app')

@section('title', 'Login - Bengkel POS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <i class="fas fa-wrench text-4xl text-gray-800 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800">Bengkel POS</h1>
            <p class="text-gray-500 mt-2">Silakan login untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-gray-800 text-white font-bold py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Default credentials:</p>
            <p class="mt-1">Admin: admin@bengkel.com / password</p>
            <p>Kasir: kasir@bengkel.com / password</p>
        </div>
    </div>
</div>
@endsection
