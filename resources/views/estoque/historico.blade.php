@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-3xl font-bold">Histórico de Movimentações</h2>
            <p class="text-gray-600 text-sm">{{ $estoque->nome }} ({{ $estoque->codigo_barras }})</p>
        </div>
        <div>
            <a href="{{ route('estoque.show', $estoque) }}" class="text-gray-500 hover:text-gray-700">
                ← Voltar
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600 font-medium">Tipo:</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('estoque.historico', $estoque) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ !request('tipo') ? 'bg-emerald-500 text-white' : 'bg-gray-100' }}">
                        Todos
                    </a>
                    <a href="{{ route('estoque.historico', array_merge(request()->query(), ['tipo' => 'entrada'])) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ request('tipo') == 'entrada' ? 'bg-green-500 text-white' : 'bg-gray-100' }}">
                        Entradas
                    </a>
                    <a href="{{ route('estoque.historico', array_merge(request()->query(), ['tipo' => 'saida'])) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ request('tipo') == 'saida' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">
                        Saídas
                    </a>
                    <a href="{{ route('estoque.historico', array_merge(request()->query(), ['tipo' => 'ajuste'])) }}"
                        class="px-3 py-1.5 rounded-md text-sm {{ request('tipo') == 'ajuste' ? 'bg-yellow-500 text-white' : 'bg-gray-100' }}">
                        Ajustes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Movimentações -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
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
                    <td class="p-4">
                        {{ $mov->data_movimentacao->format('d/m/Y') }}
                        <span class="text-gray-500 text-xs">{{ $mov->created_at->format('H:i') }}</span>
                    </td>
                    <td class="p-4 text-center">
                        @if($mov->tipo === 'entrada')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Entrada</span>
                        @elseif($mov->tipo === 'saida')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Saída</span>
                        @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Ajuste</span>
                        @endif
                    </td>
                    <td class="p-4 text-center font-semibold">
                        @if($mov->tipo === 'entrada')
                        <span class="text-green-600">+ {{ $mov->quantidade }}</span>
                        @elseif($mov->tipo === 'saida')
                        <span class="text-red-600">- {{ $mov->quantidade }}</span>
                        @else
                        <span class="text-gray-600">= {{ $mov->quantidade }}</span>
                        @endif
                    </td>
                    <td class="p-4">{{ $mov->motivo ?? '-' }}</td>
                    <td class="p-4">{{ $mov->usuario->name ?? 'Sistema' }}</td>
                    <td class="p-4">
                        @if($mov->observacoes)
                        <div class="text-gray-700" title="{{ $mov->observacoes }}">
                            {{ Str::limit($mov->observacoes, 50, '...') }}
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        Nenhuma movimentação encontrada
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

    <!-- Resumo Estatístico -->
    <div class="grid grid-cols-4 gap-4 mt-6">

        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-gray-600 text-sm">Total Entradas</p>
            <p class="text-2xl font-bold text-green-600">
                @php
                    $totalEntrada = \App\Models\EstoqueMovimentacao::where('id_produto', $estoque->id_produto)->where('tipo', 'entrada')->sum('quantidade');
                @endphp
                {{ $totalEntrada }} {{ $estoque->unidade }}
            </p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-gray-600 text-sm">Total Saídas</p>
            <p class="text-2xl font-bold text-red-600">
                @php
                    $totalSaida = \App\Models\EstoqueMovimentacao::where('id_produto', $estoque->id_produto)->where('tipo', 'saida')->sum('quantidade');
                @endphp
                {{ $totalSaida }} {{ $estoque->unidade }}
            </p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-gray-600 text-sm">Total Ajustes</p>
            <p class="text-2xl font-bold text-yellow-600">
                @php
                    $totalAjuste = \App\Models\EstoqueMovimentacao::where('id_produto', $estoque->id_produto)->where('tipo', 'ajuste')->count();
                @endphp
                {{ $totalAjuste }}
            </p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-gray-600 text-sm">Total Movimentações</p>
            <p class="text-2xl font-bold text-blue-600">
                @php
                    $total = \App\Models\EstoqueMovimentacao::where('id_produto', $estoque->id_produto)->count();
                @endphp
                {{ $total }}
            </p>
        </div>

    </div>

</div>

@endsection
