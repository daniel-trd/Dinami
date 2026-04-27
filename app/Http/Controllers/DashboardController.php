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

        $graficoLinhaFinanceiro = [
            'labelsFinanceiro' => $recebidosPorMes->pluck('mes'),
            'valoresFinanceiro' => $recebidosPorMes->pluck('total'),
        ];

        $novosPorMes = Clientes::selectRaw("
        EXTRACT(MONTH FROM data_cadastro) as mes,
        COUNT(*) as total
    ")
            ->where('data_cadastro', '>=', now()->subYear())
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $graficoLinhaCadastro = [
            'labelsCadastro' => $novosPorMes->pluck('mes'),
            'valoresCadastro' => $novosPorMes->pluck('total'),
        ];

        $graficoCadastro = [
            'labelsCadastro' => ['Novos Clientes', 'Novos Fornecedores'],
            'valoresCadastro' => [$novosClientes, $novosFornecedores],
        ];

        $clientesInativos = Clientes::where('status', 'inativo')->count();
        $fornecedoresInativos = Fornecedores::where('status', 'inativo')->count();

        return view('dashboard.index', compact(
            'tipo',
            'receber',
            'pagar',
            'recebidos',
            'pagos',
            'novosClientes',
            'novosFornecedores',
            'graficoFinanceiro',
            'graficoLinhaFinanceiro',
            'graficoLinhaCadastro',
            'graficoCadastro',
            'clientesInativos',
            'fornecedoresInativos'
        ));
    }
}
