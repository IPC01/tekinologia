@php
    $userRole = auth()->user()->role_id;
@endphp

<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out"
     x-data="{ sidebarOpen: true }">

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]">
        <h1 class="text-xl font-bold text-white">Dashboard</h1>
    </div>

    <!-- Navigation -->
    <nav class="mt-8 px-4 space-y-2">

        @if(in_array($userRole, [1, 2]))
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('dashboard') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>

            <a href="{{ route('categories.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('categories*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-tags mr-3"></i>
                Categorias
            </a>

            <a href="{{ route('products.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('products*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-box-open mr-3"></i>
                Produtos
            </a>

            <a href="{{ route('orders.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('orders*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-shopping-cart mr-3"></i>
                Pedidos/Pagamentos
            </a>

            <a href="{{ route('finance.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('finance*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-wallet mr-3"></i>
                Conta
            </a>
        @endif

        @if($userRole == 1)
            <a href="{{ route('settings.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('settings*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-cogs mr-3"></i>
                Configurações
            </a>
        @endif

        @if(in_array($userRole, [1, 2, 3]))
            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->routeIs('profile*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-user mr-3"></i>
                Perfil
            </a>

            <a href="{{ route('orders.myorders') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->is('myorders*') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-box mr-3"></i>
                Meus Pedidos
            </a>
        @endif

        @if($userRole == 3)
            <a href="{{ route('frontend.contract') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->is('contract') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-store mr-3"></i>
                Torne-se Vendedor
            </a>
        @elseif($userRole == 2)
            <a href="{{ route('frontend.contract') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200
                      text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                      {{ request()->is('contract') ? 'bg-[#d4d5ff] dark:bg-[#3d3fbf] text-[#5855eb] dark:text-[#a7a9ff]' : '' }}">
                <i class="fas fa-store-alt-slash mr-3"></i>
                Cancelar Status de Vendedor
            </a>
        @endif

    </nav>
</div>
