@extends('layouts.app')

@section('page-title', 'Clientes')

@section('content')

<div class="space-y-6">

    <!-- Header com Filtros Colapsáveis -->
    <div class="bg-white rounded-xl shadow">

        <!-- Barra de Ações -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">

            <div class="flex items-center gap-4 flex-1">
                <!-- Buscador -->
                <form method="GET" action="{{ route('cliente.index') }}" class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Buscar cliente..." value="{{ request('search') }}"
                            class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <!-- Filtros -->
                <button x-data="{ open: false }" @click="open = !open"
                    class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span class="text-sm">Filtros</span>
                </button>
            </div>

            <!-- Botão Novo -->
            <a href="{{ route('cliente.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Cliente
            </a>

        </div>

        <!-- Tags de Filtros Ativos -->
        @if(request('status') || request('search'))
        <div class="px-6 py-3 border-b border-gray-200 flex items-center gap-2 flex-wrap">
            @if(request('search'))
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                    🔍 {{ request('search') }}
                </span>
            @endif
            @if(request('status'))
                <span class="inline-flex items-center gap-2 px-3 py-1 {{ request('status') === 'ativo' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }} rounded-full text-sm">
                    {{ request('status') === 'ativo' ? '✓ Ativos' : '✕ Inativos' }}
                </span>
            @endif
            <a href="{{ route('cliente.index') }}" class="text-xs text-gray-500 hover:text-gray-700">Limpar filtros</a>
        </div>
        @endif

    </div>

    <!-- Tabela de Clientes -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">NOME</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">EMAIL</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">TELEFONE</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700">CADASTRO</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700">STATUS</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700">AÇÕES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($clientes as $cliente)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-gray-900">{{ $cliente->nome }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $cliente->email ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $cliente->telefone ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ $cliente->data_cadastro ? $cliente->data_cadastro->format('d/m/Y') : '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($cliente->status === 'ativo')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">✓ Ativo</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">✕ Inativo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('cliente.edit', $cliente) }}" class="p-2 text-gray-600 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('cliente.toggleStatus', $cliente) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="p-2 text-gray-600 hover:bg-yellow-50 hover:text-yellow-600 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <p>Nenhum cliente encontrado</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Paginação -->
    <div class="px-6">
        {{ $clientes->links() }}
    </div>

</div>

@endsection
