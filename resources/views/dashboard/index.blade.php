@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-8">Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">A Receber</p>
        <h3 class="text-2xl font-bold text-yellow-600">R$ {{ $receber ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">A Pagar</p>
        <h3 class="text-2xl font-bold text-red-600">R$ {{ $pagar ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Recebidos</p>
        <h3 class="text-2xl font-bold text-emerald-600">R$ {{ $recebidos ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Pagos</p>
        <h3 class="text-2xl font-bold text-blue-600">R$ {{ $pagos ?? 0 }}</h3>
    </div>

</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Novos Clientes (último mês)</p>
        <h3 class="text-2xl font-bold text-emerald-600">{{ $novosClientes }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Novos Fornecedores (último mês)</p>
        <h3 class="text-2xl font-bold text-blue-600">{{ $novosFornecedores }}</h3>
    </div>

@endsection