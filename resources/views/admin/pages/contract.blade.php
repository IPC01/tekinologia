@extends('admin.layouts.app')

@section('title', 'Contrato de Colaboração')
@section('page-title', 'Contrato de Colaboração')
@section('content')

    <section class=" py-10">
        <div class="container">
            <div class="hero-content text-center  mx-auto">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Termos de Colaboração</h1>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Ao aceitar este contrato, o utilizador poderá atuar como vendedor de produtos digitais na nossa
                    plataforma.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 dark:bg-gray-900 py-10">
        <div class="container mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow  mx-auto">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Contrato de Colaboração – Produtos
                    Digitais</h2>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Este acordo estabelece os termos sob os quais o utilizador poderá vender <strong>exclusivamente produtos
                        digitais</strong>
                    (como e-books, cursos, softwares, templates, áudios, vídeos, entre outros) na plataforma.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Produtos físicos não são permitidos e qualquer tentativa de comercialização poderá resultar em suspensão
                    ou exclusão da conta de vendedor.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Cada transação realizada está sujeita a uma comissão automática de
                    <strong class="text-blue-600">
                        {{ $setting->commission_rate ?? 'indefinido' }}%
                    </strong>

                    destinada à manutenção e desenvolvimento da plataforma.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    O vendedor compromete-se a disponibilizar produtos legítimos, de sua autoria ou com autorização de
                    distribuição,
                    garantindo também que o conteúdo não infringe direitos autorais ou leis em vigor.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    A entrega dos produtos digitais deverá ocorrer de forma automática ou via download, imediatamente após o
                    pagamento confirmado.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    A plataforma reserva-se o direito de auditar, remover conteúdos que violem os termos e encerrar contas
                    de vendedores
                    que desrespeitem as diretrizes estabelecidas.
                </p>

                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Ao clicar em "Aceito ser Vendedor", o utilizador concorda com os termos acima e solicita o seu
                    enquadramento como colaborador da plataforma.
                </p>

                <form action="{{ route('profile.updaterole') }}" method="POST" class="text-right">
                    @csrf
                    @if (auth()->user()->role_id == 3)
                        <button type="submit"
                            class="px-6 py-2 bg-[#d4d5ff] text-[#5855eb] hover:bg-[#c2c3f0] dark:bg-[#3d3fbf] dark:text-[#a7a9ff] dark:hover:bg-[#2f31a5] rounded-lg shadow-sm transition">
                            Aceito ser Vendedor
                        </button>
                    @elseif(auth()->user()->role_id == 2)
                        <button type="submit"
                            class="px-6 py-2 bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-800 dark:text-red-200 dark:hover:bg-red-700 rounded-lg shadow-sm transition">
                            Cancelar Vendedor
                        </button>
                    @endif
                </form>

            </div>
        </div>
    </section>

@endsection
