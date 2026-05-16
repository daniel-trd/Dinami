<?php

namespace App\Services;

use App\Models\ContasPagar;
use App\Models\ContasReceber;
use Illuminate\Database\Eloquent\Builder;

class RelatorioFinanceiroBuilder
{
    private Builder $queryPagar;
    private Builder $queryReceber;

    public function __construct()
    {
        $this->queryPagar = ContasPagar::query();
        $this->queryReceber = ContasReceber::query();
    }

    public function porPeriodo($dataInicio, $dataFim, $campo = 'data_vencimento')
    {
        $this->queryPagar->whereBetween($campo, [$dataInicio, $dataFim]);
        $this->queryReceber->whereBetween($campo, [$dataInicio, $dataFim]);
        return $this;
    }

    public function porStatus($status)
    {
        if ($status) {
            $this->queryPagar->where('status', $status);
            $this->queryReceber->where('status', $status);
        }
        return $this;
    }

    public function porFornecedor($idFornecedor)
    {
        if ($idFornecedor) {
            $this->queryPagar->where('id_fornecedor', $idFornecedor);
        }
        return $this;
    }

    public function porCliente($idCliente)
    {
        if ($idCliente) {
            $this->queryReceber->where('id_cliente', $idCliente);
        }
        return $this;
    }

    public function comRelacionamentos()
    {
        $this->queryPagar->with('fornecedor');
        $this->queryReceber->with('cliente');
        return $this;
    }

    public function resumoFinanceiro()
    {
        return [
            'pagar' => [
                'pendente' => (clone $this->queryPagar)->where('status', 'pendente')->sum('valor'),
                'pago' => (clone $this->queryPagar)->where('status', 'pago')->sum('valor'),
                'total' => (clone $this->queryPagar)->sum('valor'),
                'quantidade_pendente' => (clone $this->queryPagar)->where('status', 'pendente')->count(),
            ],
            'receber' => [
                'pendente' => (clone $this->queryReceber)->where('status', 'pendente')->sum('valor'),
                'recebido' => (clone $this->queryReceber)->where('status', 'recebido')->sum('valor'),
                'total' => (clone $this->queryReceber)->sum('valor'),
                'quantidade_pendente' => (clone $this->queryReceber)->where('status', 'pendente')->count(),
            ],
        ];
    }

    public function listagemPagar()
    {
        return $this->queryPagar->orderBy('data_vencimento')->get();
    }

    public function listagemReceber()
    {
        return $this->queryReceber->orderBy('data_vencimento')->get();
    }

    public function agrupadoPorMes()
    {
        return [
            'pagar' => $this->queryPagar->selectRaw("
                DATE_TRUNC('month', data_vencimento) as mes,
                status,
                SUM(valor) as total
            ")
                ->groupBy('mes', 'status')
                ->orderBy('mes')
                ->get(),
            'receber' => $this->queryReceber->selectRaw("
                DATE_TRUNC('month', data_vencimento) as mes,
                status,
                SUM(valor) as total
            ")
                ->groupBy('mes', 'status')
                ->orderBy('mes')
                ->get(),
        ];
    }

    public function agrupadoPorFornecedor()
    {
        return $this->queryPagar->selectRaw("
            id_fornecedor,
            COUNT(*) as quantidade,
            SUM(valor) as total,
            SUM(CASE WHEN status = 'pendente' THEN valor ELSE 0 END) as pendente
        ")
            ->with('fornecedor')
            ->groupBy('id_fornecedor')
            ->orderByRaw('SUM(valor) DESC')
            ->get();
    }

    public function agrupadoPorCliente()
    {
        return $this->queryReceber->selectRaw("
            id_cliente,
            COUNT(*) as quantidade,
            SUM(valor) as total,
            SUM(CASE WHEN status = 'pendente' THEN valor ELSE 0 END) as pendente
        ")
            ->with('cliente')
            ->groupBy('id_cliente')
            ->orderByRaw('SUM(valor) DESC')
            ->get();
    }

    public function resetar()
    {
        $this->queryPagar = ContasPagar::query();
        $this->queryReceber = ContasReceber::query();
        return $this;
    }
}
