@extends('layouts.app')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-3xl font-bold">Clientes</h2>

    <a href="{{ route('cliente.create') }}"
        class="bg-emerald-500 text-white px-4 py-2 rounded-lg hover:bg-emerald-600">
        + Novo Cliente
    </a>
</div>

<!-- FILTROS -->
<div class="bg-white p-4 rounded-xl shadow mb-6 flex items-center gap-4">

    <span class="text-sm text-gray-600 font-medium">Filtrar por:</span>

    <form method="GET" class="flex items-center gap-2">

        <a href="{{ route('cliente.index', ['status' => 'todos']) }}"
            class="px-3 py-1.5 rounded-md text-sm {{ $status == 'todos' ? 'bg-gray-500 text-white' : 'bg-gray-100' }}">
            Todos
        </a>

        <a href="{{ route('cliente.index') }}"
            class="px-3 py-1.5 rounded-md text-sm {{ !$status ? 'bg-emerald-500 text-white' : 'bg-gray-100' }}">
            Ativos
        </a>

        <a href="{{ route('cliente.index', ['status' => 'inativo']) }}"
            class="px-3 py-1.5 rounded-md text-sm {{ $status == 'inativo' ? 'bg-red-500 text-white' : 'bg-gray-100' }}">
            Inativos
        </a>

    </form>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="p-4 text-center">Nome</th>
                <th class="p-4 text-center">Email</th>
                <th class="p-4 text-center">Telefone</th>
                <th class="p-4 text-center">Data Cadastro</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($clientes as $cliente)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-4 text-center">{{ $cliente->nome }}</td>

                <td class="p-4 text-center">{{ $cliente->email ?? '-' }}</td>

                <td class="p-4 text-center">{{ $cliente->telefone ?? '-' }}</td>

                <td class="p-4 text-center">
                    {{ $cliente->data_cadastro ? date('d/m/Y', strtotime($cliente->data_cadastro)) : '-' }}
                </td>

                <td class="p-4 text-center">
                    @if($cliente->status == 'ativo')
                    <span class="text-green-600 font-semibold">Ativo</span>
                    @else
                    <span class="text-red-500 font-semibold">Inativo</span>
                    @endif
                </td>

                <td class="p-4 text-center">
                    <div class="flex justify-center items-center gap-2">

                        <!-- Editar -->
                        <a href="{{ route('cliente.edit', $cliente->id_cliente) }}"
                            class="bg-emerald-500 text-white px-3 py-1.5 text-sm rounded-md hover:bg-emerald-600 transition ">
                            Editar
                        </a>

                        <form action="{{ route('cliente.toggleStatus', $cliente->id_cliente) }}"
                            method="POST"
                            class="inline-flex">
                            @csrf
                            @method('PATCH')

                            <button
                                class="px-3 py-1.5 text-sm rounded-md text-white
                                {{ $cliente->status === 'ativo' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">

                                {{ $cliente->status === 'ativo' ? 'Inativar' : 'Ativar' }}

                            </button>
                        </form>

                    </div>

                </td>

            </tr>
            @empty
            <tr>
                <td colspan="9" class="p-6 text-center text-gray-400">
                    Nenhuma cliente encontrado
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 flex flex-col md:flex-row justify-between items-center gap-4 border-t">

        <!-- INFO -->
        <span class="text-sm text-gray-500">
            Mostrando <strong>{{ $clientes->firstItem() }}</strong>
            até <strong>{{ $clientes->lastItem() }}</strong>
            de <strong>{{ $clientes->total() }}</strong> registros
        </span>

        <!-- CONTROLES -->
        <div class="flex items-center gap-3">

            <form method="GET" class="flex items-center gap-2">

                <input type="hidden" name="status" value="{{ request('status') }}">

                <label class="text-sm text-gray-500 hidden sm:block">
                    Por página:
                </label>

                <select name="per_page"
                    onchange="this.form.submit()"
                    class="appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1.5 text-sm shadow-sm 
                       hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">

                    @foreach([10,15,20,50,75] as $qtd)
                    <option value="{{ $qtd }}"
                        {{ request('per_page',10) == $qtd ? 'selected' : '' }}>
                        {{ $qtd }}
                    </option>
                    @endforeach

                </select>

            </form>

            <!-- PAGINAÇÃO -->
            <div class="flex items-center gap-1">
                {{ $clientes->links() }}
            </div>

        </div>

    </div>

</div>

@endsection