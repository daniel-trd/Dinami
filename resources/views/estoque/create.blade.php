@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="relative flex items-center mb-6">

        <!-- Título central -->
        <h2 class="absolute left-1/2 -translate-x-1/2 text-xl font-semibold">
            Novo Produto
        </h2>

        <!-- Botão direita -->
        <div class="ml-auto">
            <a href="{{ route('estoque.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('estoque.store') }}" class="space-y-5">
            @csrf

            <!-- Linha 1 -->
            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Código de Barras</label>
                    <input type="text" name="codigo_barras" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('codigo_barras') border-red-500 @enderror"
                        value="{{ old('codigo_barras') }}">
                    @error('codigo_barras')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Nome do Produto</label>
                    <input type="text" name="nome" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('nome') border-red-500 @enderror"
                        value="{{ old('nome') }}">
                    @error('nome')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Linha 2 -->
            <div class="grid grid-cols-3 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Marca</label>
                    <input type="text" name="marca"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400"
                        value="{{ old('marca') }}">
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Preço (R$)</label>
                    <input type="number" name="preco" step="0.01" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('preco') border-red-500 @enderror"
                        value="{{ old('preco') }}">
                    @error('preco')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Unidade</label>
                    <select name="unidade" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('unidade') border-red-500 @enderror">
                        <option value="">Selecione...</option>
                        <option value="UN" {{ old('unidade') == 'UN' ? 'selected' : '' }}>Unidade (UN)</option>
                        <option value="CX" {{ old('unidade') == 'CX' ? 'selected' : '' }}>Caixa (CX)</option>
                        <option value="KG" {{ old('unidade') == 'KG' ? 'selected' : '' }}>Quilograma (KG)</option>
                        <option value="L" {{ old('unidade') == 'L' ? 'selected' : '' }}>Litro (L)</option>
                        <option value="M" {{ old('unidade') == 'M' ? 'selected' : '' }}>Metro (M)</option>
                        <option value="M2" {{ old('unidade') == 'M2' ? 'selected' : '' }}>Metro Quadrado (M²)</option>
                    </select>
                    @error('unidade')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Linha 3 -->
            <div class="grid grid-cols-3 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Estoque Mínimo</label>
                    <input type="number" name="estoque_minimo" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('estoque_minimo') border-red-500 @enderror"
                        value="{{ old('estoque_minimo', 0) }}">
                    @error('estoque_minimo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Estoque Máximo</label>
                    <input type="number" name="estoque_maximo" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('estoque_maximo') border-red-500 @enderror"
                        value="{{ old('estoque_maximo', 0) }}">
                    @error('estoque_maximo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="controla_estoque" value="1" 
                            class="rounded w-4 h-4" {{ old('controla_estoque', 1) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">Controlar Estoque</span>
                    </label>
                </div>

            </div>

            <!-- Descrição -->
            <div>
                <label class="block text-sm text-gray-500 mb-1">Descrição</label>
                <textarea name="descricao" rows="3"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400">{{ old('descricao') }}</textarea>
            </div>

            <!-- Botões -->
            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600 transition">
                    Criar Produto
                </button>
                <a href="{{ route('estoque.index') }}"
                    class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
