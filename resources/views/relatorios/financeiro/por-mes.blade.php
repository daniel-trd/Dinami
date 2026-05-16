@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Relatório - Agrupado por Mês</h2>
    <a href="{{ route('relatorios.financeiro.index') }}" class="text-emerald-600 hover:underline">← Voltar</a>
</div>

<!-- Filtros -->
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" class="flex gap-4 items-end">

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
            <input type="date" name="data_inicio" value="{{ $dataInicio }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
            <input type="date" name="data_fim" value="{{ $dataFim }}" class="w-full border rounded-lg px-4 py-2">
        </div>

        <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600">
            Filtrar
        </button>
    </form>
</div>

<!-- Contas a Pagar por Mês -->
<div class="mb-8">
    <h3 class="text-2xl font-bold mb-4">Contas a Pagar</h3>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-4 text-left">Mês</th>
                    <th class="p-4 text-center">Pendente</th>
                    <th class="p-4 text-center">Pago</th>
                    <th class="p-4 text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['pagar'] as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        {{ $item->mes ? \Carbon\Carbon::parse($item->mes)->format('M/Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        @if($item->status == 'pendente')
                            <span class="text-red-600 font-semibold">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($item->status == 'pago')
                            <span class="text-green-600 font-semibold">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center font-bold">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">Nenhum dado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Contas a Receber por Mês -->
<div>
    <h3 class="text-2xl font-bold mb-4">Contas a Receber</h3>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-4 text-left">Mês</th>
                    <th class="p-4 text-center">Pendente</th>
                    <th class="p-4 text-center">Recebido</th>
                    <th class="p-4 text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados['receber'] as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        {{ $item->mes ? \Carbon\Carbon::parse($item->mes)->format('M/Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        @if($item->status == 'pendente')
                            <span class="text-red-600 font-semibold">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($item->status == 'recebido')
                            <span class="text-green-600 font-semibold">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center font-bold">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">Nenhum dado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
