@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-3xl font-bold">Usuários</h2>
    <a href="{{ route('configuracao.usuarios.create', auth()->user()->configuracao_id ?? 1) }}"
        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">
        + Novo Usuário
    </a>
</div>

<!-- FILTROS -->
<div class="bg-white p-4 rounded-xl shadow mb-6 flex items-center gap-4">

    <span class="text-sm text-gray-600 font-medium">Filtrar por:</span>

    <form method="GET" class="flex items-center gap-2">

        <a href="{{ route('configuracao.usuarios.index', [
            'configuracao' => request()->route('configuracao'),
            'status' => 'todos'
        ]) }}"
        class="px-3 py-1.5 rounded-md text-sm {{ $status == 'todos' ? 'bg-gray-500 text-white' : 'bg-gray-100' }}">
            Todos
        </a>

        <a href="{{ route('configuracao.usuarios.index', [
            'configuracao' => request()->route('configuracao'),
            'status' => 'ativo'
        ]) }}"
            class="px-3 py-1.5 rounded-md text-sm {{ $status == 'ativo' ? 'bg-emerald-500 text-white' : 'bg-gray-100' }}">
            Ativos
        </a>

        <a href="{{ route('configuracao.usuarios.index', [
            'configuracao' => request()->route('configuracao'),
            'status' => 'inativo'
        ]) }}"
            class="px-3 py-1.5 rounded-md text-sm {{ $status == 'inativo' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">
            Inativos
        </a>

    </form>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-center">ID</th>
                <th class="p-4 text-center">Nome</th>
                <th class="p-4 text-center">Email</th>
                <th class="p-4 text-center">Data Cadastro</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($usuario as $usuario)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-4 text-center">{{ $usuario->id }}</td>

                <td class="p-4 text-center">{{ $usuario->name }}</td>

                <td class="p-4 text-center">{{ $usuario->email ?? '-' }}</td>


                <td class="p-4 text-center">
                    {{ $usuario->created_at ? date('d/m/Y', strtotime($usuario->created_at)) : '-' }}
                </td>

                <td class="p-4 text-center">
                    @if($usuario->status == 'ativo')
                    <span class="text-green-600 font-semibold">Ativo</span>
                    @else
                    <span class="text-red-500 font-semibold">Inativo</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center items-center gap-2">

                        <!-- Editar -->
                        <a href="{{ route('configuracao.usuarios.edit', [
                            'configuracao' => request()->route('configuracao'),
                            'usuario' => $usuario->id
                        ]) }}"
                            class="bg-emerald-500 text-white px-3 py-1.5 text-sm rounded-md hover:bg-emerald-600 transition ">
                            Editar
                        </a>

                        <form action="{{ route('configuracao.usuarios.toggleStatus', $usuario->id) }}"
                            method="POST"
                            class="inline-flex">
                            @csrf
                            @method('PATCH')

                            <button
                                class="px-3 py-1.5 text-sm rounded-md text-white
                                {{ $usuario->status === 'ativo' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">

                                {{ $usuario->status === 'ativo' ? 'Inativar' : 'Ativar' }}

                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="9" class="p-6 text-center text-gray-400">
                    Nenhum usuário encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection