@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Listagem - {{ $tipo === 'receber' ? 'Contas a Receber' : 'Contas a Pagar' }}</h2>
    <a href="{{ route('relatorios.financeiro.index') }}" class="text-emerald-600 hover:underline">← Voltar</a>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" class="flex gap-4 items-end">

        <input type="hidden" name="tipo" value="{{ $tipo }}">

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
            <select name="tipo" onchange="this.form.submit()" class="w-full border rounded-lg px-4 py-2">
                <option value="pagar" {{ $tipo == 'pagar' ? 'selected' : '' }}>Contas a Pagar</option>
                <option value="receber" {{ $tipo == 'receber' ? 'selected' : '' }}>Contas a Receber</option>
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border rounded-lg px-4 py-2">
                <option value="">Todos</option>
                <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="pago" {{ request('status') == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="recebido" {{ request('status') == 'recebido' ? 'selected' : '' }}>Recebido</option>
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Valor Mínimo</label>
            <input type="number" name="valor_min" placeholder="0.00" step="0.01" value="{{ request('valor_min') }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Valor Máximo</label>
            <input type="number" name="valor_max" placeholder="9999.99" step="0.01" value="{{ request('valor_max') }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600 whitespace-nowrap">
            Filtrar
        </button>
    </form>
</div>

<!-- Totais -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-gray-600 text-sm">Total</p>
        <p class="text-2xl font-bold text-emerald-600">R$ {{ number_format($totais['total'], 2, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-gray-600 text-sm">Quantidade</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totais['quantidade'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4">
        <p class="text-gray-600 text-sm">Média</p>
        <p class="text-2xl font-bold text-purple-600">R$ {{ number_format($totais['media'], 2, ',', '.') }}</p>
    </div>
</div>

<!-- Tabela -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-left">ID</th>
                <th class="p-4 text-left">{{ $tipo === 'receber' ? 'Cliente' : 'Fornecedor' }}</th>
                <th class="p-4 text-left">Descrição</th>
                <th class="p-4 text-center">Valor</th>
                <th class="p-4 text-center">Vencimento</th>
                <th class="p-4 text-center">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dados as $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4">
                    {{ $tipo === 'receber'
                    ? ($item->id_conta_receber ?? $item->id)
                    : ($item->id_conta_pagar ?? $item->id) }}
                </td>
                <td class="p-4">
                    @if($tipo === 'receber' && $item->cliente)
                        {{ $item->cliente->nome_cliente ?? 'N/A' }}
                    @elseif($tipo !== 'receber' && $item->fornecedor)
                        {{ $item->fornecedor->nome_fornecedor ?? 'N/A' }}
                    @else
                        N/A
                    @endif
                </td>
                <td class="p-4">{{ $item->descricao }}</td>
                <td class="p-4 text-right font-semibold text-red-600">R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                <td class="p-4 text-center">
                    {{ $item->data_vencimento ? $item->data_vencimento->format('d/m/Y') : '-' }}
                </td>
                <td class="p-4 text-center">
                    @if($item->status == 'pago' || $item->status == 'recebido')
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($item->status) }}</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pendente</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-gray-400">
                    Nenhum registro encontrado
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
