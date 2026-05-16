<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RelatorioFinanceiroBuilder;
use App\Helpers\RelatorioFinanceiroHelper;

class RelatorioFinanceiroController extends Controller
{
    private RelatorioFinanceiroBuilder $builder;

    public function __construct()
    {
        $this->builder = new RelatorioFinanceiroBuilder();
    }

    public function index()
    {
        $dataInicio = request('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = request('data_fim', now()->toDateString());
        $status = request('status');

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim)
            ->porStatus($status)
            ->comRelacionamentos();

        $resumo = $builder->resumoFinanceiro();
        $fluxoCaixa = RelatorioFinanceiroHelper::calcularFluxoCaixa($resumo);

        return view('relatorios.financeiro.index', [
            'resumo' => $resumo,
            'fluxoCaixa' => $fluxoCaixa,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'status' => $status,
        ]);
    }

    public function listar()
    {
        $tipo = request('tipo', 'pagar');
        $dataInicio = request('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = request('data_fim', now()->toDateString());
        $status = request('status');

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim)
            ->porStatus($status)
            ->comRelacionamentos();

        $dados = $tipo === 'receber'
            ? $builder->listagemReceber()
            : $builder->listagemPagar();

        $filtros = [
            'status' => $status,
            'valor_min' => request('valor_min'),
            'valor_max' => request('valor_max'),
        ];

        $dados = RelatorioFinanceiroHelper::aplicarFiltros(
            collect($dados),
            array_filter($filtros)
        );

        return view('relatorios.financeiro.listar', [
            'dados' => $dados,
            'tipo' => $tipo,
            'totais' => RelatorioFinanceiroHelper::calcularTotais($dados),
        ]);
    }

    public function porMes()
    {
        $dataInicio = request('data_inicio', now()->subMonths(6)->toDateString());
        $dataFim = request('data_fim', now()->toDateString());

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim);

        $dados = $builder->agrupadoPorMes();

        return view('relatorios.financeiro.por-mes', [
            'dados' => $dados,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);
    }

    public function porFornecedor()
    {
        $dataInicio = request('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = request('data_fim', now()->toDateString());

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim);

        $dados = $builder->agrupadoPorFornecedor();

        return view('relatorios.financeiro.por-fornecedor', [
            'dados' => $dados,
            'totais' => RelatorioFinanceiroHelper::calcularTotais(
                $dados->pluck('total')
            ),
        ]);
    }

    public function porCliente()
    {
        $dataInicio = request('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = request('data_fim', now()->toDateString());

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim);

        $dados = $builder->agrupadoPorCliente();

        return view('relatorios.financeiro.por-cliente', [
            'dados' => $dados,
            'totais' => RelatorioFinanceiroHelper::calcularTotais(
                $dados->pluck('total')
            ),
        ]);
    }

    public function atrasos()
    {
        $builder = (clone $this->builder)
            ->comRelacionamentos();

        $pagos = $builder->listagemPagar();
        $recebimentos = $builder->listagemReceber();

        $pagosAtrasados = RelatorioFinanceiroHelper::calcularAtrasos(collect($pagos));
        $recebimentosAtrasados = RelatorioFinanceiroHelper::calcularAtrasos(collect($recebimentos));

        return view('relatorios.financeiro.atrasos', [
            'pagosAtrasados' => $pagosAtrasados,
            'recebimentosAtrasados' => $recebimentosAtrasados,
            'totalAtrasos' => [
                'pagar' => $pagosAtrasados->sum('valor'),
                'receber' => $recebimentosAtrasados->sum('valor'),
            ],
        ]);
    }

    public function exportarJSON()
    {
        $dataInicio = request('data_inicio', now()->startOfMonth()->toDateString());
        $dataFim = request('data_fim', now()->toDateString());
        $tipo = request('tipo', 'pagar');

        $builder = (clone $this->builder)
            ->porPeriodo($dataInicio, $dataFim)
            ->comRelacionamentos();

        $dados = $tipo === 'receber'
            ? $builder->listagemReceber()
            : $builder->listagemPagar();

        return response()->json([
            'tipo' => $tipo,
            'periodo' => ['inicio' => $dataInicio, 'fim' => $dataFim],
            'dados' => $dados,
            'totais' => RelatorioFinanceiroHelper::calcularTotais(collect($dados)),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }
}
