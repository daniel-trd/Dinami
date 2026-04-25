@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="relative flex items-center mb-6">

        <!-- Título central -->
        <h2 class="absolute left-1/2 -translate-x-1/2 text-xl font-semibold">
            Editar Cliente
        </h2>

        <!-- Botão direita -->
        <div class="ml-auto">
            <a href="{{ route('cliente.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('cliente.update', $clientes->id_cliente) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Nome</label>
                    <input type="text" name="nome"
                        value="{{ $clientes->nome }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Email</label>
                    <input type="email" name="email"
                        value="{{ $clientes->email }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Telefone</label>
                    <input type="tel" name="telefone"
                        value="{{ $clientes->telefone }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">
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

</div>

@endsection