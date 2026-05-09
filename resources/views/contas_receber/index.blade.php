@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold">Contas a Receber</h2>
</div>

<div class="bg-white p-4 rounded-xl shadow mb-6">

    <div class="flex items-center justify-between gap-4">

        <!-- ESQUERDA -->
        <div class="flex items-center gap-4">

            <span class="text-sm text-gray-600 font-medium">
                Filtrar por:
            </span>

            <div class="flex items-center gap-2">

                <a href="{{ route('contas_receber.index', ['status' => 'recebido']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $status == 'recebido' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">
                    Recebidas
                </a>

                <a href="{{ route('contas_receber.index', ['status' => 'pendente']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $status == 'pendente' ? 'bg-yellow-500 text-white' : 'bg-gray-100' }}">
                    Pendentes
                </a>

            </div>

        </div>

        <!-- CENTRO -->
        <div class="flex-1 flex justify-center">

            <form method="GET" action="{{ route('contas_receber.index') }}">

                <div class="relative">

                    <!-- Ícone -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                        <svg
                            class="w-5 h-5 text-emerald-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />

                        </svg>

                    </div>

                    <!-- Input -->
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar conta a receber..."
                        value="{{ request('search') }}"
                        class="w-[450px] bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm shadow-sm
                        hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                        focus:bg-white focus:border-emerald-500">

                </div>

            </form>

        </div>

        <!-- DIREITA -->
        <div>

            <a href="{{ route('contas_receber.create') }}"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 whitespace-nowrap">
                + Nova Conta
            </a>

        </div>

    </div>

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

    <div class="p-4 border-t bg-gray-100 text-gray-600">

        <div class="grid grid-cols-3 items-center">

            <!-- ESQUERDA -->
            <div class="flex items-center gap-2">

                <form method="GET" class="flex items-center gap-2">

                    <input type="hidden" name="status" value="{{ request('status') }}">

                    <label class="text-sm hidden sm:block">
                        Por página:
                    </label>

                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="appearance-none bg-white border rounded-lg px-3 py-1.5 text-sm shadow-sm
                           hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">

                        @foreach([10,15,20,50,75] as $qtd)

                        <option value="{{ $qtd }}"
                            {{ request('per_page',10) == $qtd ? 'selected' : '' }}>

                            {{ $qtd }}

                        </option>

                        @endforeach

                    </select>

                </form>

            </div>

            <!-- CENTRO -->
            <div class="flex justify-center">
                {{ $contas->links() }}
            </div>

            <!-- DIREITA -->
            <div class="flex justify-end">

                <span class="text-sm text-gray-500 hidden sm:block">

                    Mostrando <strong>{{ $contas->firstItem() }}</strong>
                    até <strong>{{ $contas->lastItem() }}</strong>
                    de <strong>{{ $contas->total() }}</strong> registros

                </span>

            </div>

        </div>

    </div>

</div>

@endsection