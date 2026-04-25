<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Financeiro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">

    <div x-data="{ openSidebar: true }" class="flex h-screen">

        <!-- Sidebar -->
        <aside class="bg-slate-900 text-white w-64 min-h-screen p-6 flex flex-col">

            <!-- Logo -->
            <div class="mb-10 text-center">
                <h1 class="text-2xl font-bold text-emerald-400"> Dinami</h1>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col text-sm">

                <!-- Dashboard -->
                <a href="{{ route('dashboard.index') }}"
                    class="px-4 py-2 hover:bg-slate-800 rounded-lg">
                    📊 Dashboard
                </a>

                <!-- CADASTRO -->
                <div x-data="{ openCadastro: {{ request()->routeIs('clientes.*') || request()->routeIs('fornecedores.*') ? 'true' : 'false' }} }">

                    <button @click="openCadastro = !openCadastro"
                        class="w-full flex justify-between items-center px-4 py-2 hover:bg-slate-800 rounded-lg">

                        📁 Cadastro

                        <svg :class="{ 'rotate-90': openCadastro }"
                            class="w-3 h-3 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div x-show="openCadastro" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <a href="{{ route('cliente.index') }}" 
                        class="px-3 py-2 hover:bg-slate-800 rounded-md">
                            👤 Clientes
                        </a>

                        <a href="{{ route('fornecedor.index') }}" 
                        class="px-3 py-2 hover:bg-slate-800 rounded-md">
                            🏢 Fornecedores
                        </a>

                    </div>
                </div>

                <!-- FINANCEIRO -->
                <div x-data="{ 
        openFinanceiro: {{ request()->routeIs('contas_pagar.*') || request()->routeIs('contas_receber.*') ? 'true' : 'false' }} 
    }">

                    <button @click="openFinanceiro = !openFinanceiro"
                        class="w-full flex justify-between px-4 py-2 hover:bg-slate-800 rounded-lg">

                        💼 Financeiro
                        <svg :class="{ 'rotate-90': openFinanceiro }"
                            class="w-3 h-3 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-show="openFinanceiro" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <a href="{{ route('contas_pagar.index') }}"
                            class="px-3 py-2 hover:bg-slate-800 rounded-md">
                            💸 Contas a Pagar
                        </a>

                        <a href="{{ route('contas_receber.index') }}"
                            class="px-3 py-2 hover:bg-slate-800 rounded-md">
                            💰 Contas a Receber
                        </a>

                    </div>
                </div>

            </nav>

        </aside>

        <!-- Conteúdo -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <button @click="openSidebar = !openSidebar"
                    class="text-gray-600 hover:text-black">
                    ☰
                </button>

                <div class="font-semibold">XXX User XXX</div>
            </header>

            <!-- Page -->
            <main class="p-8 overflow-y-auto">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>