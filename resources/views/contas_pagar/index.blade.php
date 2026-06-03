@extends('layouts.app')

@section('page-title', 'Contas a Pagar')

@section('content')

<div class="space-y-6">

    <!-- Header com Filtros -->
    <div class="bg-white rounded-xl shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center gap-4">

            <div class="flex items-center gap-3 flex-1">
                <!-- Busca -->
                <form method="GET" action="{{ route('contas_pagar.index') }}" class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Buscar conta..." value="{{ request('search') }}"
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <!-- Filtros de Status -->
                <div class="flex gap-2">
                    <a href="{{ route('contas_pagar.index', ['status' => 'pendente']) }}"
                        class="px-4 py-2 text-sm rounded-lg transition {{ !request('status') ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Pendentes
                    </a>
                    <a href="{{ route('contas_pagar.index', ['status' => 'pago']) }}"
                        class="px-4 py-2 text-sm rounded-lg transition {{ request('status') === 'pago' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Pagas
                    </a>
                </div>
            </div>

            <a href="{{ route('contas_pagar.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Conta
            </a>

        </div>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">FORNECEDOR</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">VALOR</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">VENCIMENTO</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">PAGAMENTO</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">STATUS</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700">AÇÕES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($contas as $conta)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-gray-900">{{ $conta->fornecedor->nome ?? 'N/A' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-red-600">R$ {{ number_format($conta->valor, 2, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $vencimento = $conta->data_vencimento;
                            $classe = ($vencimento && $vencimento < now() && $conta->status !== 'pago') ? 'text-red-600' : 'text-gray-600';
                        @endphp
                        <p class="text-sm {{ $classe }}">{{ $vencimento ? $vencimento->format('d/m/Y') : '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $conta->data_pagamento ? $conta->data_pagamento->format('d/m/Y') : '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($conta->status === 'pago')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">✓ Pago</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">⏱ Pendente</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('contas_pagar.edit', $conta) }}" class="p-2 text-gray-600 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">Nenhuma conta encontrada</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="px-6">
        {{ $contas->links() }}
    </div>

</div>

@endsection
