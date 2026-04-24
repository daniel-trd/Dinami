@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="relative flex items-center mb-6">

        <!-- Título central -->
        <h2 class="absolute left-1/2 -translate-x-1/2 text-xl font-semibold">
            Editar Conta
        </h2>

        <!-- Botão direita -->
        <div class="ml-auto">
            <a href="{{ route('contas_pagar.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('contas_pagar.update', $contas->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">

                <!-- Descrição -->
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Descrição</label>
                    <input type="text" name="descricao"
                        value="{{ $contas->descricao }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <!-- Fornecedor -->
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Fornecedor</label>
                    <input type="text" name="fornecedor"
                        value="{{ $contas->fornecedor }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <!-- Valor -->
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Valor</label>
                    <input type="text" name="valor"
                        value="{{ $contas->valor }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <!-- Data -->
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Vencimento</label>
                    <input type="date" name="data_vencimento"
                        value="{{ optional($contas->data_vencimento)->format('Y-m-d') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Data de Pagamento</label>
                    <input type="date" name="data_pagamento"
                        value="{{ optional($contas->data_pagamento)->format('Y-m-d') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Status</label>
                    <select name="status"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                        <option value="pendente" {{ $contas->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="pago" {{ $contas->status == 'pago' ? 'selected' : '' }}>Pago</option>
                    </select>
                </div>

            </div>

            <!-- Botão centralizado -->
            <div class="flex justify-center mt-6">
                <button
                    class="bg-emerald-500 text-white px-8 py-2 rounded-lg hover:bg-emerald-600 transition">
                    Atualizar
                </button>
            </div>

        </form>

    </div>

    @endsection