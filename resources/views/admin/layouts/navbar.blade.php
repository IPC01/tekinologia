<div class="ml-64 min-h-screen">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between px-6 py-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">@yield('page-title', 'Dashboard')</h2>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <i class="fas fa-sun text-yellow-500" x-show="darkMode"></i>
                    <i class="fas fa-moon text-gray-600" x-show="!darkMode"></i>
                </button>

                <!-- User Menu -->
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
                          <a href="{{ route('frontend.shop') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Loja
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
            </div>
        </div>
    </header>
    <!-- Page Content -->
