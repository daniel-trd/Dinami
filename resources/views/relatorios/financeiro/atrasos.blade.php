@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Contas Atrasadas</h2>
    <a href="{{ route('relatorios.financeiro.index') }}" class="text-emerald-600 hover:underline">← Voltar</a>
</div>

<!-- Resumo de Atrasos -->
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl shadow p-6">
        <h3 class="text-gray-700 text-sm font-semibold mb-2">A PAGAR (ATRASADAS)</h3>
        <p class="text-3xl font-bold text-red-600">R$ {{ number_format($totalAtrasos['pagar'], 2, ',', '.') }}</p>
        <p class="text-gray-600 text-xs mt-2">{{ $pagosAtrasados->count() }} conta(s)</p>
    </div>

    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl shadow p-6">
        <h3 class="text-gray-700 text-sm font-semibold mb-2">A RECEBER (ATRASADAS)</h3>
        <p class="text-3xl font-bold text-red-600">R$ {{ number_format($totalAtrasos['receber'], 2, ',', '.') }}</p>
        <p class="text-gray-600 text-xs mt-2">{{ $recebimentosAtrasados->count() }} conta(s)</p>
    </div>
</div>

<!-- Contas a Pagar Atrasadas -->
<div class="mb-8">
    <h3 class="text-2xl font-bold mb-4">Contas a Pagar Atrasadas</h3>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-red-100 text-red-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4 text-left">Fornecedor</th>
                    <th class="p-4 text-left">Descrição</th>
                    <th class="p-4 text-center">Valor</th>
                    <th class="p-4 text-center">Vencimento</th>
                    <th class="p-4 text-center">Dias Atrasado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pagosAtrasados as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        {{ $item->fornecedor->nome_fornecedor ?? 'N/A' }}
                    </td>
                    <td class="p-4">{{ $item->descricao }}</td>
                    <td class="p-4 text-center font-bold text-red-600">R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        {{ $item->data_vencimento ? $item->data_vencimento->format('d/m/Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $item->data_vencimento ? now()->diffInDays($item->data_vencimento, false) : '-' }} dias
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">Nenhuma conta atrasada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Contas a Receber Atrasadas -->
<div>
    <h3 class="text-2xl font-bold mb-4">Contas a Receber Atrasadas</h3>
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-red-100 text-red-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="p-4 text-left">Cliente</th>
                    <th class="p-4 text-left">Descrição</th>
                    <th class="p-4 text-center">Valor</th>
                    <th class="p-4 text-center">Vencimento</th>
                    <th class="p-4 text-center">Dias Atrasado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recebimentosAtrasados as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        {{ $item->cliente->nome_cliente ?? 'N/A' }}
                    </td>
                    <td class="p-4">{{ $item->descricao }}</td>
                    <td class="p-4 text-center font-bold text-red-600">R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        {{ $item->data_vencimento ? $item->data_vencimento->format('d/m/Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $item->data_vencimento ? now()->diffInDays($item->data_vencimento, false) : '-' }} dias
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">Nenhuma conta atrasada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
