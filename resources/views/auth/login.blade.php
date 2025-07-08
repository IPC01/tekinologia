@extends('frontend.layouts.app')

@section('title', 'Login')
@section('page-title', 'Login')

@section('content')
<br><br>
<div class="max-w-md mx-auto mt-12 mb-12 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg ">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Entrar na sua conta</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4 mt-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input id="email" type="email" name="email" required autofocus
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                @error('email') border-red-500 @enderror" 
                value="{{ old('email') }}">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha</label>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <div>
                <input type="checkbox" name="remember" id="remember" class="mr-1">
                <label for="remember" class="text-sm text-gray-700 dark:text-gray-300">Lembrar-me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Esqueceu a senha?</a>
            @endif
        </div>

        <button type="submit"
            class="w-full px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">
            Entrar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        Não tem uma conta?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Registre-se aqui</a>
    </p>
</div>
@endsection
