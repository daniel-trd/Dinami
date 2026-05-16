@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Relatório Financeiro</h2>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" action="{{ route('relatorios.financeiro.index') }}" class="flex gap-4 items-end">

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
            <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
            <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border rounded-lg px-4 py-2">
                <option value="">Todos</option>
                <option value="pendente" {{ $status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="pago" {{ $status == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="recebido" {{ $status == 'recebido' ? 'selected' : '' }}>Recebido</option>
            </select>
        </div>

        <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600">
            Filtrar
        </button>
    </form>
</div>

<!-- Resumo Financeiro -->
<div class="grid grid-cols-4 gap-4 mb-6">

    <!-- Contas a Pagar -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">A PAGAR</h3>
        <div class="space-y-2">
            <div>
                <p class="text-gray-500 text-xs">Pendentes</p>
                <p class="text-2xl font-bold text-red-600">R$ {{ number_format($resumo['pagar']['pendente'], 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Quantidade: {{ $resumo['pagar']['quantidade_pendente'] }}</p>
            </div>
        </div>
    </div>

    <!-- Contas a Receber -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">A RECEBER</h3>
        <div class="space-y-2">
            <div>
                <p class="text-gray-500 text-xs">Pendentes</p>
                <p class="text-2xl font-bold text-green-600">R$ {{ number_format($resumo['receber']['pendente'], 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-xs">Quantidade: {{ $resumo['receber']['quantidade_pendente'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Pago -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">JÁ PAGOS</h3>
        <div class="space-y-2">
            <p class="text-2xl font-bold text-blue-600">R$ {{ number_format($resumo['pagar']['pago'], 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Total Recebido -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">JÁ RECEBIDOS</h3>
        <div class="space-y-2">
            <p class="text-2xl font-bold text-blue-600">R$ {{ number_format($resumo['receber']['recebido'], 2, ',', '.') }}</p>
        </div>
    </div>

</div>

<!-- Fluxo de Caixa -->
<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">A RECEBER</h3>
        <p class="text-2xl font-bold text-green-600">R$ {{ number_format($fluxoCaixa['a_receber'], 2, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">A PAGAR</h3>
        <p class="text-2xl font-bold text-red-600">R$ {{ number_format($fluxoCaixa['a_pagar'], 2, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 {{ $fluxoCaixa['fluxo_positivo'] >= 0 ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500' }}">
        <h3 class="text-gray-600 text-sm font-semibold mb-2">FLUXO ({{ strtoupper($fluxoCaixa['status']) }})</h3>
        <p class="text-2xl font-bold {{ $fluxoCaixa['fluxo_positivo'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
            R$ {{ number_format(abs($fluxoCaixa['fluxo_positivo']), 2, ',', '.') }}
        </p>
    </div>

</div>

<!-- Botões de Ação -->
<div class="flex gap-3 mb-6">
    <a href="{{ route('relatorios.financeiro.listar') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        Listagem Detalhada
    </a>
    <a href="{{ route('relatorios.financeiro.porMes') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
        Por Mês
    </a>
    <a href="{{ route('relatorios.financeiro.porFornecedor') }}" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
        Por Fornecedor
    </a>
    <a href="{{ route('relatorios.financeiro.porCliente') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
        Por Cliente
    </a>
    <a href="{{ route('relatorios.financeiro.atrasos') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
        Atrasos
    </a>
</div>

@endsection
