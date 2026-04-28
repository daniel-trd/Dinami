<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\Clientes;
use App\Models\Fornecedores;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo = request('tipo', 'financeiro');

        return view('dashboard.index', [
            'tipo' => $tipo,
            ...$this->getFinanceiroData($tipo),
            ...$this->getCadastroData($tipo),
            ...$this->getGraficos(),
            ...$this->getStatusResumo(),
        ]);
    }
    private function getFinanceiroData($tipo)
    {
        if ($tipo !== 'financeiro') {
            return [
                'pagar' => 0,
                'receber' => 0,
                'pagos' => 0,
                'recebidos' => 0,
            ];
        }

        return [
            'pagar' => ContasPagar::where('status', 'pendente')->sum('valor'),
            'receber' => ContasReceber::where('status', 'pendente')->sum('valor'),
            'pagos' => ContasPagar::where('status', 'pago')->sum('valor'),
            'recebidos' => ContasReceber::where('status', 'recebido')->sum('valor'),
        ];
    }
    private function getCadastroData($tipo)
    {
        if ($tipo !== 'cadastro') {
            return [
                'novosClientes' => 0,
                'novosFornecedores' => 0,
            ];
        }

        return [
            'novosClientes' => Clientes::where('data_cadastro', '>=', now()->subMonth())->count(),
            'novosFornecedores' => Fornecedores::where('data_cadastro', '>=', now()->subMonth())->count(),
        ];
    }
    private function getGraficos()
    {
        $recebidosPorMes = ContasReceber::selectRaw("
            TO_CHAR(data_pagamento, 'Mon') as mes,
            SUM(valor) as total
        ")
            ->whereNotNull('data_pagamento')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $novosPorMes = Clientes::selectRaw("
            TO_CHAR(data_cadastro, 'Month') as mes,
            COUNT(*) as total
        ")
            ->where('data_cadastro', '>=', now()->subYear())
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return [
            'graficoLinhaFinanceiro' => [
                'labelsFinanceiro' => $recebidosPorMes->pluck('mes'),
                'valoresFinanceiro' => $recebidosPorMes->pluck('total'),
            ],
            'graficoLinhaCadastro' => [
                'labelsCadastro' => $novosPorMes->pluck('mes'),
                'valoresCadastro' => $novosPorMes->pluck('total'),
            ],
        ];
    }
    private function getStatusResumo()
    {
        return [
            'clientesInativos' => Clientes::where('status', 'inativo')->count(),
            'fornecedoresInativos' => Fornecedores::where('status', 'inativo')->count(),
            'clientesAtivos' => Clientes::where('status', 'ativo')->count(),
            'fornecedoresAtivos' => Fornecedores::where('status', 'ativo')->count(),
        ];
    }
}
