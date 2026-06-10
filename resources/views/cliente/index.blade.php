@extends('layouts.app')

@section('page-title', 'Clientes')

@section('content')

<div class="space-y-6">

    <!-- Header com Filtros Colapsáveis -->
    <div class="bg-white rounded-xl shadow">

        <!-- Barra de Ações -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">

            <div class="flex items-center gap-4 flex-1">

                <form
                    method="GET"
                    action="{{ route('cliente.index') }}"
                    class="flex items-center gap-4 flex-1">

                    <!-- Buscador -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Buscar cliente..."
                                class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">

                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div x-data="{ open: false }" class="relative">

                        <button
                            type="button"
                            @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2.5 text-gray-700 hover:bg-gray-50 border border-gray-300 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </svg>
                            Filtros
                        </button>

                        <div
                            x-show="open"
                            @click.away="
                            if (!document.querySelector('.flatpickr-calendar.open')) {
                                open = false;
                            }"
                            x-transition
                            class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border p-4 z-50">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="w-full border rounded-lg px-3 py-2">

                                    <option value=""
                                        {{ request('status') == '' ? 'selected' : '' }}>
                                        Todos
                                    </option>

                                    <option value="ativo"
                                        {{ request('status') == 'ativo' ? 'selected' : '' }}>
                                        Ativo
                                    </option>

                                    <option value="inativo"
                                        {{ request('status') == 'inativo' ? 'selected' : '' }}>
                                        Inativo
                                    </option>

                                </select>
                                <label class="block text-sm font-medium text-gray-700 mt-4 mb-2">
                                    Data de Cadastro
                                </label>

                                <div class="grid grid-cols-2 gap-2 mb-4">

                                    <input
                                        id="data_cadastro_inicio"
                                        type="date"
                                        name="data_cadastro_inicio"
                                        value="{{ request('data_cadastro_inicio') }}"
                                        placeholder="📅 Data inicial"
                                        class="w-full border rounded-lg px-3 py-2">

                                    <input
                                        id="data_cadastro_fim"
                                        type="date"
                                        name="data_cadastro_fim"
                                        value="{{ request('data_cadastro_fim') }}"
                                        placeholder="📅 Data final"
                                        class="w-full border rounded-lg px-3 py-2">

                                </div>

                            </div>

                            <div class="flex justify-between">

                                <a
                                    href="{{ route('cliente.index') }}"
                                    class="px-4 py-2 text-sm bg-gray-100 rounded-lg">
                                    Limpar
                                </a>

                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg">
                                    Aplicar
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

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
        @if(
        request()->hasAny([
        'status',
        'search',
        'data_cadastro_inicio',
        'data_cadastro_fim'
        ]) || session('error')
        )
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
            @if(request('data_cadastro_inicio') || request('data_cadastro_fim'))
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-50 text-purple-700 rounded-full text-sm">

                @php
                $dataInicio = request('data_cadastro_inicio');
                $dataFim = request('data_cadastro_fim');
                @endphp

                @if($dataInicio && $dataFim)
                📅 {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}
                -
                {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                @endif

                @if($dataInicio && !$dataFim)
                📅 A partir de {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }}
                @endif

                @if(!$dataInicio && $dataFim)
                📅 Até {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                @endif

            </span>
            @endif
            @if(session('error'))
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 text-red-700 rounded-full text-sm">
                ⚠️ Intervalo de datas inválido
            </span>
            @endif
            <a href="{{ route('cliente.index') }}" class="text-xs text-gray-500 hover:text-gray-700">Limpar filtros</a>
        </div>
        @endif

    </div>

    <!-- Tabela de Clientes -->
    <div class="bg-white rounded-xl shadow overflow-visible">

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
                                    @click="window.location.href = '{{ route('cliente.edit', $cliente) }}'; openMenu = false;"
                                    class="w-full text-center px-4 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">
                                    Editar
                                </button>

                                <!-- Inativar -->
                                <button
                                    @click="openDelete = true; openMenu = false;"
                                    class="w-full text-center px-4 py-2 text-sm text-gray-600 hover:bg-red-50 hover:text-red-600">
                                    Inativar
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
                                        Deseja inativar esse cliente?
                                    </h2>

                                    <p class="mt-2 text-sm text-gray-600 text-left">
                                        Tem certeza que deseja inativar este cliente?
                                        Esta ação não poderá ser desfeita.
                                    </p>

                                    <div class="mt-6 flex justify-center gap-3">
                                        <button
                                            @click="openDelete = false"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                            Cancelar
                                        </button>

                                        <form
                                            action="{{ route('cliente.toggleStatus', $cliente) }}"
                                            method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')

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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        flatpickr("#data_cadastro_inicio", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true
        });

        flatpickr("#data_cadastro_fim", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            allowInput: true
        });

    });
</script>

@endsection