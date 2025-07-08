@extends('frontend.layouts.app')

@section('title', 'Produtos')
@section('page-title', 'Produtos')
@section('content')

<section class="products-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="logo">Sobre Nós</h1>
            <p>Este sistema foi desenvolvido exclusivamente para fins de testes e demonstração.  
            Não representa uma solução final ou produto em produção.</p>
        </div>
    </div>
</section>
<section class="contact-section py-10 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Fale Connosco</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                Para questões relacionadas com o desenvolvimento ou para esclarecimento de dúvidas, entre em contacto connosco.
            </p>
        </div>

        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Informações de Contacto</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-2">
                📧 Email: <a href="mailto:ivaniapercechirindza@gmail.com" class="text-blue-600 hover:underline">ivaniapercechirindza@gmail.com</a>
            </p>
            <p class="text-gray-700 dark:text-gray-300">
                💬 Estamos disponíveis para esclarecer qualquer dúvida relacionada ao projeto ou possíveis melhorias.
            </p>
        </div>
    </div>
</section>


    @endsection