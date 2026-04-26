<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\Clientes;
use App\Models\Fornecedores;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = request('tipo', 'financeiro');

        // inicializa tudo
        $pagar = $receber = $pagos = $recebidos = 0;
        $novosClientes = $novosFornecedores = 0;

        if ($tipo === 'financeiro') {
            $pagar = ContasPagar::where('status', 'pendente')->sum('valor');
            $receber = ContasReceber::where('status', 'pendente')->sum('valor');

            $pagos = ContasPagar::where('status', 'pago')->sum('valor');
            $recebidos = ContasReceber::where('status', 'recebido')->sum('valor');
        }

        if ($tipo === 'cadastro') {
            $novosClientes = Clientes::where('data_cadastro', '>=', now()->subMonth())->count();
            $novosFornecedores = Fornecedores::where('data_cadastro', '>=', now()->subMonth())->count();
        }

        $graficoFinanceiro = [
            'labels' => ['A Receber', 'A Pagar', 'Recebidos', 'Pagos'],
            'valores' => [$receber, $pagar, $recebidos, $pagos],
        ];

        $recebidosPorMes = ContasReceber::selectRaw("
        EXTRACT(MONTH FROM data_pagamento) as mes,
        SUM(valor) as total
    ")
            ->whereNotNull('data_pagamento')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $graficoLinha = [
            'labels' => $recebidosPorMes->pluck('mes'),
            'valores' => $recebidosPorMes->pluck('total'),
        ];

        return view('dashboard.index', compact(
            'tipo',
            'receber',
            'pagar',
            'recebidos',
            'pagos',
            'novosClientes',
            'novosFornecedores',
            'graficoFinanceiro',
            'graficoLinha'
        ));
    }
}
