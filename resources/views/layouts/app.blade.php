<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Financeiro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 px-4 py-2 hover:bg-slate-800 rounded-lg">

                    <!-- Ícone -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-5 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 13h8V3H3v10zm10 8h8v-6h-8v6zm0-10h8V3h-8v8zM3 21h8v-4H3v4z" />
                    </svg>

                    <span>Dashboard</span>
                </a>

                <!-- CADASTRO -->
                <div x-data="{ openCadastro: {{ request()->routeIs('cliente.*') || request()->routeIs('fornecedor.*') ? 'true' : 'false' }} }">

                    <!-- Botão -->
                    <button @click="openCadastro = !openCadastro"
                        class="w-full flex items-center justify-between px-4 py-2 hover:bg-slate-800 rounded-lg">

                        <div class="flex items-center gap-2">

                            <!-- Ícone Cadastro -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>


                            <span>Cadastro</span>
                        </div>

                        <!-- Seta -->
                        <svg :class="{ 'rotate-90': openCadastro }"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>

                    </button>

                    <!-- Submenu -->
                    <div x-show="openCadastro" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <!-- Clientes -->
                        <a href="{{ route('cliente.index') }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A10.954 10.954 0 0112 15c2.5 0 4.847.82 6.879 2.204M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            Clientes
                        </a>

                        <!-- Fornecedores -->
                        <a href="{{ route('fornecedor.index') }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>


                            Fornecedores
                        </a>

                    </div>
                </div>

                <!-- FINANCEIRO -->
                <div x-data="{ 
        openFinanceiro: {{ request()->routeIs('contas_pagar.*') || request()->routeIs('contas_receber.*') ? 'true' : 'false' }} 
    }">

                    <button @click="openFinanceiro = !openFinanceiro"
                        class="w-full flex items-center justify-between px-4 py-2 hover:bg-slate-800 rounded-lg">

                        <div class="flex items-center gap-2">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>


                            <span>Financeiro</span>
                        </div>

                        <!-- Seta -->
                        <svg :class="{ 'rotate-90': openFinanceiro }"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>

                    </button>

                    <div x-show="openFinanceiro" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <a href="{{ route('contas_pagar.index') }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-red-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>

                            Contas a Pagar
                        </a>

                        <a href="{{ route('contas_receber.index') }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>

                            Contas a Receber
                        </a>

                    </div>
                </div>

                <div x-data="{ 
        openRelatorio: {{ request()->routeIs('relatorio.*') || request()->routeIs('relatorio.*') ? 'true' : 'false' }} 
    }">

                    <button @click="openRelatorio = !openRelatorio"
                        class="w-full flex items-center justify-between px-4 py-2 hover:bg-slate-800 rounded-lg">

                        <div class="flex items-center gap-2">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                            </svg>




                            <span>Relatórios</span>
                        </div>

                        <!-- Seta -->
                        <svg :class="{ 'rotate-90': openRelatorio }"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>

                    </button>

                    <div x-show="openRelatorio" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <a href="{{ route('contas_pagar.index') }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>


                            Financeiro
                        </a>

                    </div>
                </div>


                <div x-data="{ 
        openConfiguracao: {{ request()->routeIs('configuracao.*') || request()->routeIs('configuracao.*') ? 'true' : 'false' }} 
    }">

                    <button @click="openConfiguracao = !openConfiguracao"
                        class="w-full flex items-center justify-between px-4 py-2 hover:bg-slate-800 rounded-lg">

                        <div class="flex items-center gap-2">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>



                            <span>Configuração</span>
                        </div>

                        <!-- Seta -->
                        <svg :class="{ 'rotate-90': openConfiguracao }"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" />
                        </svg>

                    </button>

                    <div x-show="openConfiguracao" x-transition
                        class="ml-6 mt-1 flex flex-col border-l border-slate-700 pl-3">

                        <a href="{{ route('configuracao.usuarios.index', auth()->user()->configuracao_id ?? 1) }}"
                            class="flex items-center gap-2 px-3 py-2 hover:bg-slate-800 rounded-md">

                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 text-emerald-400"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>


                            Usuários
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

                <div class="flex items-center gap-2 font-semibold">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-gray-600"
                        fill="none" viewBox="0 0 22 22" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A10.954 10.954 0 0112 15c2.5 0 4.847.82 6.879 2.204M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    {{ auth()->user()->name ?? 'Usuário' }}

                </div>
            </header>

            <div class="fixed top-5 right-5 z-50 flex flex-col gap-2 w-80">

                @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="bg-slate-800 text-white px-4 py-3 rounded-lg shadow-lg">
                    <div class="flex justify-between items-start">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false">✕</button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg">
                    <div class="flex justify-between items-start">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false">✕</button>
                    </div>
                </div>
                @endif

            </div>

            <!-- Page -->
            <main class="p-8 overflow-y-auto">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>