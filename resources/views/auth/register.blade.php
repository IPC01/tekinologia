@extends('frontend.layouts.app')

@section('title', 'Registrar')
@section('page-title', 'Registrar')

@section('content')
<br><br>
<div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow relative mt-12 mb-12">
    {{-- Botão fechar (pode adaptar para o modal, aqui só para exemplo) --}}
  

    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Criar Conta</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                value="{{ old('name') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
            <input id="email" name="email" type="email" required autocomplete="username"
                value="{{ old('email') }}"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha *</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Senha -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Senha *</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('login') }}" 
               class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
               Já tem conta?
            </a>
            <button type="submit"
                class="px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">
                Registrar
            </button>
        </div>
    </form>
</div>
@endsection
