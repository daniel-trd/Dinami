@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-8">

    <!-- Atalhos Rápidos -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('cliente.create') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-emerald-500">
            <svg class="w-8 h-8 text-emerald-600 mb-3 group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V9.5m-12-5h5m-5 3h5m1-8v5m2.5-2.5h5" stroke="currentColor" stroke-width="1.5" fill="none"/>
                <path fill-rule="evenodd" d="M18 10a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            <h3 class="font-semibold text-gray-800 text-sm">Novo Cliente</h3>
            <p class="text-xs text-gray-500 mt-1">Cadastrar cliente</p>
        </a>

        <a href="{{ route('contas_pagar.create') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-red-500">
            <svg class="w-8 h-8 text-red-600 mb-3 group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l-1.383 2.447a.75.75 0 01-1.324 0L7.22 13H5a2 2 0 01-2-2V5zm5 4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
            </svg>
            <h3 class="font-semibold text-gray-800 text-sm">Conta a Pagar</h3>
            <p class="text-xs text-gray-500 mt-1">Registrar pagamento</p>
        </a>

        <a href="{{ route('contas_receber.create') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-emerald-500">
            <svg class="w-8 h-8 text-emerald-600 mb-3 group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2 2a1 1 0 011-1h14a1 1 0 011 1v6a1 1 0 01-1 1H3a1 1 0 01-1-1V2zm11 3a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd" />
                <path d="M2 9a1 1 0 011 1v6a1 1 0 001 1h14a1 1 0 001-1v-6a1 1 0 00-1-1H3a1 1 0 00-1 1v6a1 1 0 001 1z" />
            </svg>
            <h3 class="font-semibold text-gray-800 text-sm">Conta a Receber</h3>
            <p class="text-xs text-gray-500 mt-1">Registrar recebimento</p>
        </a>

        <a href="{{ route('estoque.create') }}" class="group bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
            <svg class="w-8 h-8 text-blue-600 mb-3 group-hover:scale-110 transition" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
            </svg>
            <h3 class="font-semibold text-gray-800 text-sm">Novo Produto</h3>
            <p class="text-xs text-gray-500 mt-1">Cadastrar produto</p>
        </a>
    </div>

    <!-- Cards Informativos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card: Contas a Receber -->
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Contas a Receber</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">R$ {{ number_format($receber ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-2">Valor total pendente</p>
                </div>
                <svg class="w-12 h-12 text-emerald-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.16 5.314l4.897-4.096A2 2 0 0118 2.983V17a2 2 0 01-2 2H4a2 2 0 01-2-2V3a2 2 0 012-2h.159z" />
                </svg>
            </div>
            <a href="{{ route('contas_receber.index') }}" class="mt-4 text-sm text-emerald-600 hover:text-emerald-700 font-medium">Ver detalhes →</a>
        </div>

        <!-- Card: Contas a Pagar -->
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Contas a Pagar</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">R$ {{ number_format($pagar ?? 0, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-2">Valor total a pagar</p>
                </div>
                <svg class="w-12 h-12 text-red-100" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <a href="{{ route('contas_pagar.index') }}" class="mt-4 text-sm text-red-600 hover:text-red-700 font-medium">Ver detalhes →</a>
        </div>

        <!-- Card: Clientes -->
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Clientes Ativos</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalClientes ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-2">Cadastrados no sistema</p>
                </div>
                <svg class="w-12 h-12 text-blue-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                </svg>
            </div>
            <a href="{{ route('cliente.index') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-700 font-medium">Ver detalhes →</a>
        </div>

        <!-- Card: Produtos em Estoque -->
        <div class="bg-white rounded-xl shadow p-6 border-t-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Produtos</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalProdutos ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-2">Cadastrados</p>
                </div>
                <svg class="w-12 h-12 text-purple-100" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" />
                </svg>
            </div>
            <a href="{{ route('estoque.index') }}" class="mt-4 text-sm text-purple-600 hover:text-purple-700 font-medium">Ver detalhes →</a>
        </div>

    </div>

    <!-- Tabelas Resumidas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Últimas Contas a Receber -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Últimas Contas a Receber</h3>
                    <a href="{{ route('contas_receber.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Ver mais</a>
                </div>
            </div>
            <div class="divide-y">
                @forelse($ultimasContasReceber ?? [] as $cr)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $cr->cliente->nome ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $cr->data_vencimento ? $cr->data_vencimento->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-emerald-600">R$ {{ number_format($cr->valor, 2, ',', '.') }}</p>
                        <p class="text-xs {{ $cr->status === 'pago' ? 'text-emerald-600' : 'text-yellow-600' }}">{{ ucfirst($cr->status) }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">
                    Nenhuma conta a receber
                </div>
                @endforelse
            </div>
        </div>

        <!-- Últimas Contas a Pagar -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Últimas Contas a Pagar</h3>
                    <a href="{{ route('contas_pagar.index') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Ver mais</a>
                </div>
            </div>
            <div class="divide-y">
                @forelse($ultimasContasPagar ?? [] as $cp)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $cp->fornecedor->nome ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $cp->data_vencimento ? $cp->data_vencimento->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-red-600">R$ {{ number_format($cp->valor, 2, ',', '.') }}</p>
                        <p class="text-xs {{ $cp->status === 'pago' ? 'text-emerald-600' : 'text-yellow-600' }}">{{ ucfirst($cp->status) }}</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">
                    Nenhuma conta a pagar
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection
