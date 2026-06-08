@extends('layouts.app')

@section('page-title', 'Estoque - Produtos')

@section('content')

<div class="space-y-6">

    <!-- Header com Filtros -->
    <div class="bg-white rounded-xl shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center gap-4">

            <div class="flex items-center gap-3 flex-1">
                <!-- Busca -->
                <form method="GET" action="{{ route('estoque.index') }}" class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Buscar produto..." value="{{ request('search') }}"
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <!-- Filtros -->
                <div class="flex gap-2">
                    <a href="{{ route('estoque.index', ['status' => 'ativo']) }}"
                        class="px-4 py-2 text-sm rounded-lg transition {{ request('status') === 'ativo' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Ativos
                    </a>
                    <a href="{{ route('estoque.index', ['estoque' => 'baixo']) }}"
                        class="px-4 py-2 text-sm rounded-lg transition {{ request('estoque') === 'baixo' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Estoque Baixo
                    </a>
                </div>
            </div>

            <a href="{{ route('estoque.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Produto
            </a>

        </div>
    </div>

    <!-- Tabela -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">CÓDIGO</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">PRODUTO</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">MARCA</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700">PREÇO</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">ESTOQUE</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">STATUS</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700">AÇÕES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($produtos as $produto)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="text-xs font-mono text-gray-600">{{ $produto->codigo_barras }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('estoque.show', $produto) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                            {{ $produto->nome }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $produto->marca ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="text-sm font-semibold text-gray-900">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $saldo = $produto->estoques()->sum('quantidade');
                        $classe = $saldo < $produto->estoque_minimo ? 'text-red-600' : ($saldo > $produto->estoque_maximo ? 'text-blue-600' : 'text-green-600');
                            @endphp
                            <p class="text-sm font-semibold {{ $classe }}">{{ $saldo }} {{ $produto->unidade }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($produto->status === 'ativo')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">✓ Ativo</span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">✕ Inativo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('estoque.show', $produto) }}" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Detalhes">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <div x-data="{ openMenu: false, openDelete: false }" class="relative inline-block">

                                <!-- Botão de ações -->
                                <button
                                    @click="openMenu = !openMenu"
                                    class="p-2 text-gray-600 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Menu Dropdown -->
                                <div
                                    x-show="openMenu"
                                    @click.away="openMenu = false"
                                    x-transition
                                    class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg z-40">
                                    <!-- Editar -->
                                    <button
                                        href="{{ route('estoque.edit', $produto) }}"
                                        class="w-full text-center px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                                        Editar
                                    </button>

                                    <!-- Excluir -->
                                    <button
                                        @click="openDelete = true; openMenu = false;"
                                        class="w-full text-center px-4 py-2 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600">
                                        Excluir
                                    </button>
                                </div>

                                <!-- Modal de confirmação -->
                                <div
                                    x-show="openDelete"
                                    x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center"
                                    style="display: none;">
                                    <!-- Fundo escuro -->
                                    <div
                                        class="absolute inset-0 bg-black/50"
                                        @click="openDelete = false"></div>

                                    <!-- Caixa do modal -->
                                    <div
                                        class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                                        <h2 class="text-lg font-semibold text-gray-800 text-center">
                                            Deseja excluir esse produto?
                                        </h2>

                                        <p class="mt-2 text-sm text-gray-600 text-left">
                                            Tem certeza que deseja excluir este produto?
                                            Esta ação não poderá ser desfeita.
                                        </p>

                                        <div class="mt-6 flex justify-center gap-3">
                                            <button
                                                @click="openDelete = false"
                                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                                Cancelar
                                            </button>

                                            <form
                                                action="{{ route('estoque.destroy', $produto) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                    Confirmar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <p class="text-sm">Nenhum produto encontrado</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div class="px-6">
        {{ $produtos->links() }}
    </div>

</div>

@endsection