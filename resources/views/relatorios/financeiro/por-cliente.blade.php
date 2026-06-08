@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Relatório - Por Cliente</h2>
    <a href="{{ route('relatorios.financeiro.index') }}" class="text-emerald-600 hover:underline">← Voltar</a>
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
                <th class="p-4 text-left">Cliente</th>
                <th class="p-4 text-center">Quantidade</th>
                <th class="p-4 text-center">Pendente</th>
                <th class="p-4 text-center">Total</th>
                <th class="p-4 text-center">% do Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dados as $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 font-semibold">
                    {{ $item->cliente->nome ?? 'N/A' }}
                </td>
                <td class="p-4 text-center">{{ $item->quantidade }}</td>
                <td class="p-4 text-center">
                    <span class="text-red-600 font-semibold">R$ {{ number_format($item->pendente, 2, ',', '.') }}</span>
                </td>
                <td class="p-4 text-center font-bold">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                <td class="p-4 text-center">
                    @php
                    $percentual = !empty($totais['total'])
                    ? ($item->total / $totais['total']) * 100
                    : 0;
                    @endphp
                    <span class="text-purple-600 font-semibold">{{ number_format($percentual, 2, ',', '.') }}%</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-400">Nenhum dado disponível</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection