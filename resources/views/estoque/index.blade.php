@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-3xl font-bold">Estoque - Produtos</h2>
</div>

<!-- FILTROS -->
<div class="bg-white p-4 rounded-xl shadow mb-6">

    <div class="flex items-center justify-between gap-4">

        <!-- ESQUERDA -->
        <div class="flex items-center gap-4">

            <span class="text-sm text-gray-600 font-medium">
                Filtrar por:
            </span>

            <div class="flex items-center gap-2">

                <a href="{{ route('estoque.index', ['status' => 'todos']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $status == 'todos' ? 'bg-gray-500 text-white' : 'bg-gray-100' }}">
                    Todos
                </a>

                <a href="{{ route('estoque.index') }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ !$status ? 'bg-emerald-500 text-white' : 'bg-gray-100' }}">
                    Ativos
                </a>

                <a href="{{ route('estoque.index', ['status' => 'inativo']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $status == 'inativo' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">
                    Inativos
                </a>

                <span class="text-gray-300">|</span>

                <a href="{{ route('estoque.index', ['estoque' => 'baixo']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $estoque == 'baixo' ? 'bg-yellow-500 text-white' : 'bg-gray-100' }}">
                    Estoque Baixo
                </a>

                <a href="{{ route('estoque.index', ['estoque' => 'alto']) }}"
                    class="px-3 py-1.5 rounded-md text-sm {{ $estoque == 'alto' ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
                    Estoque Alto
                </a>

            </div>

        </div>

        <!-- CENTRO -->
        <div class="flex-1 flex justify-center mr-20">

            <form method="GET" action="{{ route('estoque.index') }}">

                <div class="relative">

                    <!-- Ícone -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                    </div>

                    <!-- Input -->
                    <input type="text" name="search" placeholder="Buscar por nome, código ou marca..."
                        value="{{ request('search') }}"
                        class="w-[450px] bg-gray-100 border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm shadow-sm
                   hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                   focus:bg-white focus:border-emerald-500">

                </div>

            </form>

        </div>

        <!-- DIREITA -->
        <div>

            <a href="{{ route('estoque.create') }}"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600 whitespace-nowrap">
                + Novo Produto
            </a>

        </div>

    </div>

</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-left">Código</th>
                <th class="p-4 text-left">Nome do Produto</th>
                <th class="p-4 text-center">Marca</th>
                <th class="p-4 text-center">Preço</th>
                <th class="p-4 text-center">Unidade</th>
                <th class="p-4 text-center">Estoque</th>
                <th class="p-4 text-center">Mín/Máx</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($produtos as $produto)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-4 text-left font-mono text-xs">{{ $produto->codigo_barras }}</td>

                <td class="p-4 text-left">
                    <a href="{{ route('estoque.show', $produto) }}" class="text-emerald-600 hover:text-emerald-700">
                        {{ $produto->nome }}
                    </a>
                </td>

                <td class="p-4 text-center">{{ $produto->marca ?? '-' }}</td>

                <td class="p-4 text-center font-semibold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>

                <td class="p-4 text-center">{{ $produto->unidade }}</td>

                <td class="p-4 text-center">
                    @php
                        $saldo = $produto->estoques()->sum('quantidade');
                        $classe = $saldo < $produto->estoque_minimo ? 'text-red-600 font-semibold' : ($saldo > $produto->estoque_maximo ? 'text-blue-600' : 'text-green-600');
                    @endphp
                    <span class="{{ $classe }}">{{ $saldo }} {{ $produto->unidade }}</span>
                </td>

                <td class="p-4 text-center text-gray-600">
                    {{ $produto->estoque_minimo }}/{{ $produto->estoque_maximo }}
                </td>

                <td class="p-4 text-center">
                    @if($produto->status == 'ativo')
                    <span class="text-green-600 font-semibold">Ativo</span>
                    @else
                    <span class="text-red-500 font-semibold">Inativo</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center items-center gap-2">

                        <!-- Ver -->
                        <a href="{{ route('estoque.show', $produto) }}"
                            class="bg-blue-500 text-white px-2 py-1 text-xs rounded hover:bg-blue-600 transition">
                            Ver
                        </a>

                        <!-- Editar -->
                        <a href="{{ route('estoque.edit', $produto) }}"
                            class="bg-emerald-500 text-white px-2 py-1 text-xs rounded-md hover:bg-emerald-600 transition">
                            Editar
                        </a>

                        <!-- Toggle Status -->
                        <form action="{{ route('estoque.toggleStatus', $produto) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                class="bg-yellow-500 text-white px-2 py-1 text-xs rounded hover:bg-yellow-600 transition">
                                {{ $produto->status === 'ativo' ? 'Desativar' : 'Ativar' }}
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="9" class="p-8 text-center text-gray-500">
                    Nenhum produto encontrado
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="px-4 py-3 border-t">
        {{ $produtos->links() }}
    </div>

</div>

@endsection
