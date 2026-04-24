@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-8">Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Saldo Atual</p>
        <h3 class="text-2xl font-bold text-emerald-600">R$ {{ $saldoAtual ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">A Receber</p>
        <h3 class="text-2xl font-bold text-blue-600">R$ {{ $receber ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">A Pagar</p>
        <h3 class="text-2xl font-bold text-red-600">R$ {{ $pagar ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-400 text-sm">Lucro Mês</p>
        <h3 class="text-2xl font-bold text-purple-600">R$ {{ $lucro ?? 0 }}</h3>
    </div>

</div>

@endsection