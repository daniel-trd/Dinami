@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="relative flex items-center mb-6">

        <!-- Título central -->
        <h2 class="absolute left-1/2 -translate-x-1/2 text-xl font-semibold">
            Registrar Movimentação - {{ $estoque->nome }}
        </h2>

        <!-- Botão direita -->
        <div class="ml-auto">
            <a href="{{ route('estoque.show', $estoque) }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">

        <form method="POST" action="{{ route('estoque.storeMovimentacao', $estoque) }}" class="space-y-5">
            @csrf

            <!-- Linha 1 -->
            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Tipo de Movimentação</label>
                    <select name="tipo" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('tipo') border-red-500 @enderror">
                        <option value="">Selecione...</option>
                        <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada em Estoque</option>
                        <option value="saida" {{ old('tipo') == 'saida' ? 'selected' : '' }}>Saída de Estoque</option>
                        <option value="ajuste" {{ old('tipo') == 'ajuste' ? 'selected' : '' }}>Ajuste de Inventário</option>
                    </select>
                    @error('tipo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Quantidade</label>
                    <input type="number" name="quantidade" required min="1"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('quantidade') border-red-500 @enderror"
                        value="{{ old('quantidade') }}">
                    @error('quantidade')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Linha 2 -->
            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Data da Movimentação</label>
                    <input type="date" name="data_movimentacao" required
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 @error('data_movimentacao') border-red-500 @enderror"
                        value="{{ old('data_movimentacao', date('Y-m-d')) }}">
                    @error('data_movimentacao')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-500 mb-1">Motivo / Referência</label>
                    <input type="text" name="motivo"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400"
                        placeholder="Ex: Compra NF #123, Venda Pedido #456"
                        value="{{ old('motivo') }}">
                </div>

            </div>

            <!-- Preço Custo (apenas para entrada) -->
            <div id="precoCusto" style="display: none;">
                <label class="block text-sm text-gray-500 mb-1">Preço de Custo Unitário (R$)</label>
                <input type="number" name="preco_custo" step="0.01"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400"
                    value="{{ old('preco_custo', $estoque->preco) }}">
            </div>

            <!-- Observações -->
            <div>
                <label class="block text-sm text-gray-500 mb-1">Observações</label>
                <textarea name="observacoes" rows="3"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400"
                    placeholder="Informações adicionais sobre a movimentação...">{{ old('observacoes') }}</textarea>
            </div>

            <!-- Resumo -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>Saldo Atual:</strong> <span id="saldoAtual">{{ $estoque->estoques()->sum('quantidade') }}</span> {{ $estoque->unidade }}
                </p>
                <p class="text-sm text-blue-800 mt-1">
                    <strong>Saldo Após Movimentação:</strong> <span id="saldoNovo">-</span> {{ $estoque->unidade }}
                </p>
            </div>

            <!-- Botões -->
            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="bg-emerald-500 text-white px-6 py-2 rounded-lg hover:bg-emerald-600 transition">
                    Registrar Movimentação
                </button>
                <a href="{{ route('estoque.show', $estoque) }}"
                    class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</div>

<script>
    const tipoSelect = document.querySelector('select[name="tipo"]');
    const quantidadeInput = document.querySelector('input[name="quantidade"]');
    const precoCustoDiv = document.getElementById('precoCusto');
    const saldoAtuaInput = parseInt(document.getElementById('saldoAtual').textContent);

    function atualizarSaldo() {
        const tipo = tipoSelect.value;
        const quantidade = parseInt(quantidadeInput.value) || 0;

        let saldoNovo = saldoAtuaInput;
        if (tipo === 'entrada') {
            saldoNovo += quantidade;
        } else if (tipo === 'saida') {
            saldoNovo -= quantidade;
        } else if (tipo === 'ajuste') {
            saldoNovo = quantidade;
        }

        document.getElementById('saldoNovo').textContent = saldoNovo >= 0 ? saldoNovo : '⚠️ ' + saldoNovo;
    }

    tipoSelect.addEventListener('change', function() {
        precoCustoDiv.style.display = this.value === 'entrada' ? 'block' : 'none';
        atualizarSaldo();
    });

    quantidadeInput.addEventListener('input', atualizarSaldo);
</script>

@endsection
