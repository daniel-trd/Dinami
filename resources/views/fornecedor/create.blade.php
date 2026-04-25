@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="relative flex items-center mb-6">

        <!-- Título central -->
        <h2 class="absolute left-1/2 -translate-x-1/2 text-xl font-semibold">
            Novo Fornecedor
        </h2>

        <!-- Botão direita -->
        <div class="ml-auto">
            <a href="{{ route('fornecedor.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('fornecedor.store') }}" class="space-y-5">
            @csrf

            <!-- Linha 1 -->
            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Nome - Razão Social</label>
                    <input type="text" name="nome"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>


                <div>
                    <label class="block text-sm text-gray-500 mb-1">Telefone</label>
                    <input type="tel" name="telefone"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Status</label>
                    <select name="status"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600">
                        Salvar
                    </button>

                </div>

            </div>

        </form>

    </div>

    @endsection