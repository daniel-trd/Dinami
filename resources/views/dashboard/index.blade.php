@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-8">Dashboard</h2>

<div class="bg-white p-4 rounded-xl shadow mb-6 flex items-center gap-4">

    <span class="text-sm text-gray-600 font-medium">Visualizar:</span>

    <a href="{{ route('dashboard', ['tipo' => 'financeiro']) }}"
        class="px-3 py-1.5 rounded-md text-sm {{ $tipo == 'financeiro' ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
        Financeiro
    </a>

    <a href="{{ route('dashboard', ['tipo' => 'cadastro']) }}"
        class="px-3 py-1.5 rounded-md text-sm {{ $tipo == 'cadastro' ? 'bg-emerald-500 text-white' : 'bg-gray-100' }}">
        Cadastro
    </a>

</div>

@if($tipo == 'financeiro')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">A Receber</p>
        <h3 class="text-2xl font-bold text-yellow-600">R$ {{ $receber ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">A Pagar</p>
        <h3 class="text-2xl font-bold text-red-600">R$ {{ $pagar ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Recebidos</p>
        <h3 class="text-2xl font-bold text-emerald-600">R$ {{ $recebidos ?? 0 }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Pagos</p>
        <h3 class="text-2xl font-bold text-blue-600">R$ {{ $pagos ?? 0 }}</h3>
    </div>


    <div class="bg-white p-6 rounded-2xl shadow ">
        <canvas id="graficoFinanceiro"></canvas>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <canvas id="graficoLinha"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('graficoFinanceiro');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($graficoFinanceiro['labels']),
                datasets: [{
                    label: 'Financeiro',
                    data: @json($graficoFinanceiro['valores']),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>

    <script>
        const ctxLinha = document.getElementById('graficoLinha');

        new Chart(ctxLinha, {
            type: 'line',
            data: {
                labels: @json($graficoLinha['labels']),
                datasets: [{
                    label: 'Recebidos por mês',
                    data: @json($graficoLinha['valores']),
                    tension: 0.4 // deixa a linha suave
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

</div>

@endif

@if($tipo == 'cadastro')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Novos Clientes (último mês)</p>
        <h3 class="text-2xl font-bold text-emerald-600">{{ $novosClientes }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-400 text-sm">Novos Fornecedores (último mês)</p>
        <h3 class="text-2xl font-bold text-blue-600">{{ $novosFornecedores }}</h3>
    </div>

</div>

@endif

@endsection