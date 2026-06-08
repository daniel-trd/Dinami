<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão - {{ auth()->user()->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50 font-sans">

    <div class="flex h-screen bg-gray-50">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-white shadow-lg flex flex-col">

            <!-- Logo -->
            <div class="px-6 py-8 border-b border-slate-700">
                <h1 class="text-2xl font-bold text-emerald-400">🚀 Gestão</h1>
                <p class="text-xs text-gray-400 mt-2">Sistema de Gestão</p>
            </div>

            <!-- Menu -->
            <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white' : 'hover:bg-slate-800 text-gray-300' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm10-6h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V7a1 1 0 011-1z" />
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Separator -->
                <div class="my-4 h-px bg-slate-700"></div>

                <!-- CADASTROS -->
                <div x-data="{ open: {{ request()->routeIs('cliente.*') || request()->routeIs('fornecedor.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-800 transition text-gray-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2H3a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-2V5a2 2 0 00-2-2H5zM4 5h10v2H4V5zm-3 8h14v4H1v-4z" />
                            </svg>
                            <span class="font-medium">Cadastros</span>
                        </div>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 mt-2 space-y-1 border-l-2 border-slate-700 pl-4">
                        <a href="{{ route('cliente.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('cliente.*') ? 'bg-slate-800 text-emerald-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                            Clientes
                        </a>
                        <a href="{{ route('fornecedor.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('fornecedor.*') ? 'bg-slate-800 text-emerald-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM2 15a4 4 0 008 0v2H2v-2z" />
                            </svg>
                            Fornecedores
                        </a>
                    </div>
                </div>

                <!-- FINANCEIRO -->
                <div x-data="{ open: {{ request()->routeIs('contas_pagar.*') || request()->routeIs('contas_receber.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-800 transition text-gray-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                            <span class="font-medium">Financeiro</span>
                        </div>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 mt-2 space-y-1 border-l-2 border-slate-700 pl-4">
                        <a href="{{ route('contas_pagar.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('contas_pagar.*') ? 'bg-slate-800 text-red-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" clip-rule="evenodd" />
                            </svg>
                            Contas a Pagar
                        </a>
                        <a href="{{ route('contas_receber.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('contas_receber.*') ? 'bg-slate-800 text-emerald-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" clip-rule="evenodd" />
                            </svg>
                            Contas a Receber
                        </a>
                    </div>
                </div>

                <!-- ESTOQUE -->
                <div x-data="{ open: {{ request()->routeIs('estoque.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-800 transition text-gray-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                            </svg>
                            <span class="font-medium">Estoque</span>
                        </div>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 mt-2 space-y-1 border-l-2 border-slate-700 pl-4">
                        <a href="{{ route('estoque.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('estoque.*') ? 'bg-slate-800 text-blue-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z" />
                            </svg>
                            Produtos
                        </a>
                    </div>
                </div>

                <!-- RELATÓRIOS -->
                <div x-data="{ open: {{ request()->routeIs('relatorios.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-800 transition text-gray-300">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                            <span class="font-medium">Relatórios</span>
                        </div>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="ml-4 mt-2 space-y-1 border-l-2 border-slate-700 pl-4">
                        <a href="{{ route('relatorios.financeiro.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('relatorios.*') ? 'bg-slate-800 text-purple-400' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-800' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5z" />
                            </svg>
                            Financeiro
                        </a>
                    </div>
                </div>

                <!-- Separator -->
                <div class="my-4 h-px bg-slate-700"></div>

                <!-- CONFIGURAÇÃO -->
                <a href="{{ route('configuracao.usuarios.index', 1) }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('configuracao.*') ? 'bg-slate-800 text-gray-300' : 'hover:bg-slate-800 text-gray-400' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Configuração</span>
                </a>

            </nav>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-slate-700">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 text-gray-400 hover:text-red-400 transition text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L13 9.586V5a1 1 0 10-2 0v4.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3z" clip-rule="evenodd" />
                        </svg>
                        Sair
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- TOP BAR -->
            <header class="bg-white border-b border-gray-200 px-8 py-4 shadow-sm">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ date('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="p-8">
                    @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" @click="show=false" x-transition
                        class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3 cursor-pointer hover:bg-emerald-100">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-emerald-800">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-medium text-red-800">Erro ao processar</p>
                            <ul class="mt-2 space-y-1">
                                @foreach($errors->all() as $error)
                                <li class="text-sm text-red-700">• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>

        </div>

    </div>

</body>

</html>
