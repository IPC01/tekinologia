<header class="bg-white dark:bg-gray-900 shadow">
    <nav class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="logo font-bold text-xl text-[#5855eb]"><a href="{{route('frontend.index')}}">TEKINOLOGIA</a></div>

        <!-- Navegação -->
   <ul class="nav-links flex space-x-6">
    <li>
        <a href="{{ route('frontend.shop') }}"
           class="{{ request()->is('shop') ? 'text-[#5855eb] font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
            Loja
        </a>
    </li>
    <li>
        <a href="{{ route('frontend.about') }}"
           class="{{ request()->is('about') ? 'text-[#5855eb] font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
            Sobre nós
        </a>
    </li>
</ul>

        <!-- Ações à direita -->
        <div class="flex items-center space-x-4">
            <!-- Botão de tema -->
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class="fas fa-moon text-gray-700 dark:text-gray-300" id="theme-icon"></i>
            </button>

            @auth
                <!-- Usuário autenticado -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        @php
                            $initial = strtoupper(substr(Auth::user()->name, 0, 1));
                        @endphp
                        <div class="w-8 h-8 bg-[#5855eb] rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">{{ $initial }}</span>
                        </div>
                        <span class="text-sm">{{ auth()->user()->name }}</span>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Entrar no painel
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Visitante (não autenticado) -->
                <a href="{{ route('login') }}"
                    class="text-sm px-4 py-2 text-[#5855eb] border border-[#5855eb] rounded-lg hover:bg-[#f0f0ff] transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="text-sm px-4 py-2 bg-[#5855eb] text-white rounded-lg hover:bg-[#4744d3] transition">
                    Registar
                </a>
            @endauth
        </div>
    </nav>
</header>
