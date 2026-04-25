@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Contas a Pagar</h2>

    <a href="{{ route('contas_pagar.create') }}"
        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">
        + Nova Conta
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-center">ID</th>
                <th class="p-4 text-center">Descrição</th>
                <th class="p-4 text-center">Valor</th>
                <th class="p-4 text-center">Fornecedor</th>
                <th class="p-4 text-center">Vencimento</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Data Cadastro</th>
                <th class="p-4 text-center">Data Pagamento</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($contas as $conta)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-4 text-center">{{ $conta->id_conta_pagar }}</td>

                <td class="p-4 text-center">{{ $conta->descricao }}</td>

                <td class="p-4 text-red-600 font-semibold text-center">
                    R$ {{ number_format($conta->valor, 2, ',', '.') }}
                </td>

                <td class="p-4 text-center">{{ $conta->fornecedor->nome ?? '-' }}</td>

                <td class="p-4 text-center">
                    {{ $conta->data_vencimento ? \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') : '-' }}
                </td>

                <td class="p-4 text-center">
                    @if($conta->status == 'pago')
                    <span class="text-green-600 font-semibold">Pago</span>
                    @else
                    <span class="text-yellow-500 font-semibold">Pendente</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    {{ $conta->data_cadastro ? date('d/m/Y', strtotime($conta->data_cadastro)) : '-' }}
                </td>

                <td class="p-4 text-center">
                    {{ $conta->data_pagamento ? date('d/m/Y', strtotime($conta->data_pagamento)) : '-' }}
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center items-center gap-2">

                        <!-- Editar -->
                        <a href="{{ route('contas_pagar.edit', $conta->id_conta_pagar) }}"
                            class="bg-emerald-500 text-white px-3 py-1.5 text-sm rounded-md hover:bg-emerald-600 transition ">
                            Editar
                        </a>

                        <!-- Excluir -->
                        <form action="{{ route('contas_pagar.destroy', $conta->id_conta_pagar) }}"
                            method="POST"
                            class="inline-flex">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1.5 text-sm rounded-md">
                                Excluir
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="9" class="p-6 text-center text-gray-400">
                    Nenhuma conta cadastrada
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection