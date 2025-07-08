@extends('admin.layouts.app')

@section('title', $settings ? 'Editar Configurações' : 'Criar Configurações')
@section('page-title', $settings ? 'Editar Configurações' : 'Criar Configurações')

@section('content')
<div class="mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $settings ? 'Atualizar Informações' : 'Informações Iniciais' }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ $settings ? 'Altere os campos desejados e clique em “Atualizar”.' : 'Preencha os campos abaixo para configurar o sistema.' }}
            </p>
        </div>

        {{-- FORMULÁRIO --}}
        <form method="POST"
              action="{{ $settings
                         ? route('settings.update', $settings->id)
                         : route('settings.store') }}"
              class="p-6 space-y-6">
            @csrf
            @if($settings)
                @method('PUT') {{-- Spoof PUT/PATCH --}}
            @endif

            {{-- Taxa de comissão --}}
            <div>
                <label for="commission_rate"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Taxa de Comissão (%) *
                </label>
                <input type="number" step="0.01" id="commission_rate" name="commission_rate"
                       value="{{ old('commission_rate', $settings->commission_rate ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('commission_rate')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Moeda --}}
            <div>
                <label for="currency"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Moeda (ex.: MZN, USD) *
                </label>
                <input type="text" id="currency" name="currency"
                       value="{{ old('currency', $settings->currency ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('currency')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Valor mínimo de pagamento --}}
            <div>
                <label for="payout_minimum"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Saque Mínimo *
                </label>
                <input type="number" step="0.01" id="payout_minimum" name="payout_minimum"
                       value="{{ old('payout_minimum', $settings->payout_minimum ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('payout_minimum')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dias de atraso do pagamento --}}
            <div>
                <label for="payout_delay_days"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Dias de Atraso para Pagamento *
                </label>
                <input type="number" id="payout_delay_days" name="payout_delay_days"
                       value="{{ old('payout_delay_days', $settings->payout_delay_days ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('payout_delay_days')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- E‑mail de suporte --}}
            <div>
                <label for="support_email"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    E‑mail de Suporte *
                </label>
                <input type="email" id="support_email" name="support_email"
                       value="{{ old('support_email', $settings->support_email ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('support_email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nome do site --}}
            <div>
                <label for="site_name"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nome do Site *
                </label>
                <input type="text" id="site_name" name="site_name"
                       value="{{ old('site_name', $settings->site_name ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                              focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                @error('site_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ações --}}
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-3 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">
                    Voltar
                </a>

                <button type="submit"
                        class="px-6 py-3 bg-[#d4d5ff] dark:bg-[#3d3fbf]
                               text-[#5855eb] dark:text-[#a7a9ff]
                               hover:bg-[#c2c3fa] dark:hover:bg-[#3537a3]
                               rounded-lg shadow-sm transition-colors duration-200">
                    {{ $settings ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
