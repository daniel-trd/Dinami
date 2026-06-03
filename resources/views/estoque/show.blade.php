@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-3xl font-bold">{{ $estoque->nome }}</h2>
            <p class="text-gray-600 text-sm">Código: {{ $estoque->codigo_barras }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('estoque.edit', $estoque) }}"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">
                Editar
            </a>
            <a href="{{ route('estoque.index') }}" class="text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-6">

        <!-- Card: Estoque Total -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-600 text-sm mb-2">Saldo Total</div>
            <div class="text-3xl font-bold text-emerald-600">{{ $totalEmEstoque }} {{ $estoque->unidade }}</div>
            <div class="text-gray-600 text-xs mt-2">Mín: {{ $estoque->estoque_minimo }} | Máx: {{ $estoque->estoque_maximo }}</div>
        </div>

        <!-- Card: Valor em Estoque -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-600 text-sm mb-2">Valor Total</div>
            <div class="text-3xl font-bold text-blue-600">R$ {{ number_format($valorTotalEstoque, 2, ',', '.') }}</div>
            <div class="text-gray-600 text-xs mt-2">Preço Custo</div>
        </div>

        <!-- Card: Preço Venda -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-gray-600 text-sm mb-2">Preço Unitário</div>
            <div class="text-3xl font-bold text-yellow-600">R$ {{ number_format($estoque->preco, 2, ',', '.') }}</div>
            <div class="text-gray-600 text-xs mt-2">Status: <span class="font-semibold {{ $estoque->status == 'ativo' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($estoque->status) }}</span></div>
        </div>

    </div>

    <!-- Informações Gerais -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Informações do Produto</h3>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 text-sm">Marca</p>
                <p class="text-lg font-semibold">{{ $estoque->marca ?? 'Não informada' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Unidade</p>
                <p class="text-lg font-semibold">{{ $estoque->unidade }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-600 text-sm">Descrição</p>
                <p class="text-base">{{ $estoque->descricao ?? 'Sem descrição' }}</p>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="flex gap-3 mb-6">
        <a href="{{ route('estoque.createMovimentacao', $estoque) }}"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
            + Registrar Movimentação
        </a>
        <a href="{{ route('estoque.historico', $estoque) }}"
            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
            Ver Histórico Completo
        </a>
    </div>

    <!-- Últimas Movimentações -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Últimas Movimentações</h3>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">Data</th>
                    <th class="p-4 text-center">Tipo</th>
                    <th class="p-4 text-center">Quantidade</th>
                    <th class="p-4 text-left">Motivo</th>
                    <th class="p-4 text-left">Usuário</th>
                    <th class="p-4 text-left">Observações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimentacoes as $mov)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4">{{ $mov->data_movimentacao->format('d/m/Y') }}</td>
                    <td class="p-4 text-center">
                        @if($mov->tipo === 'entrada')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Entrada</span>
                        @elseif($mov->tipo === 'saida')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Saída</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Ajuste</span>
                        @endif
                    </td>
                    <td class="p-4 text-center font-semibold">{{ $mov->quantidade }}</td>
                    <td class="p-4">{{ $mov->motivo ?? '-' }}</td>
                    <td class="p-4">{{ $mov->usuario->name ?? 'Sistema' }}</td>
                    <td class="p-4">{{ $mov->observacoes ? Str::limit($mov->observacoes, 50) : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        Nenhuma movimentação registrada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="px-6 py-3 border-t">
            {{ $movimentacoes->links() }}
        </div>

    </div>

</div>

@endsection
