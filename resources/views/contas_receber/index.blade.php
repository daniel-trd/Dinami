@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Contas a Receber</h2>

    <a href="{{ route('contas_receber.create') }}"
       class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">
        + Nova Receita
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-center">ID</th>
                <th class="p-4 text-center">Descrição</th>
                <th class="p-4 text-center">Valor</th>
                <th class="p-4 text-center">Cliente</th>
                <th class="p-4 text-center">Vencimento</th>
                <th class="p-4 text-center">Data Pagamento</th>
                <th class="p-4 text-center">Data Cadastro</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($contas as $conta)
            <tr class="border-t hover:bg-gray-50 text-center">

                <td class="p-4">{{ $conta->id_conta_receber }}</td>

                <td class="p-4">{{ $conta->descricao }}</td>

                <td class="p-4 text-emerald-600 font-semibold">
                    R$ {{ number_format($conta->valor, 2, ',', '.') }}
                </td>

                <td class="p-4">{{ $conta->cliente->nome ?? '-' }}</td>

                <td class="p-4">{{ $conta->data_vencimento ? date('d/m/Y', strtotime($conta->data_vencimento)) : '-' }}</td>

                
                <td class="p-4">{{ $conta->data_cadastro ? date('d/m/Y', strtotime($conta->data_cadastro)) : '-' }}</td>
                
                <td class="p-4">{{ $conta->data_pagamento ? date('d/m/Y', strtotime($conta->data_pagamento)) : '-' }}</td>
                
                <td class="p-4">
                    @if($conta->status == 'recebido')
                        <span class="text-green-600 font-semibold">Recebido</span>
                    @else
                        <span class="text-yellow-500 font-semibold">Pendente</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center items-center gap-2">

                        <!-- Editar -->
                        <a href="{{ route('contas_receber.edit', $conta->id_conta_receber) }}"
                            class="bg-emerald-500 text-white px-3 py-1.5 text-sm rounded-md hover:bg-emerald-600 transition ">
                            Editar
                        </a>

                        <!-- Excluir -->
                        <form action="{{ route('contas_receber.destroy', $conta->id_conta_receber) }}"
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