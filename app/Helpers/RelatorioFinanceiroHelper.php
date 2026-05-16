<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class RelatorioFinanceiroHelper
{
    public static function formatarValor($valor)
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }

    public static function formatarData($data)
    {
        if (!$data) {
            return 'Sem data';
        }
        return $data->format('d/m/Y');
    }

    public static function calcularTotais(Collection $dados)
    {
        return [
            'total' => $dados->sum('valor'),
            'quantidade' => $dados->count(),
            'media' => $dados->count() > 0 ? $dados->sum('valor') / $dados->count() : 0,
        ];
    }

    public static function statusBadge($status)
    {
        $badges = [
            'pendente' => ['classe' => 'badge bg-warning', 'texto' => 'Pendente'],
            'pago' => ['classe' => 'badge bg-success', 'texto' => 'Pago'],
            'recebido' => ['classe' => 'badge bg-success', 'texto' => 'Recebido'],
        ];

        return $badges[$status] ?? ['classe' => 'badge bg-secondary', 'texto' => $status];
    }

    public static function calcularAtrasos(Collection $dados)
    {
        $hoje = now()->toDateString();
        return $dados->filter(function ($item) use ($hoje) {
            return $item->status === 'pendente' && $item->data_vencimento < $hoje;
        });
    }

    public static function percentualPago($total, $pago)
    {
        if ($total == 0) {
            return 0;
        }
        return round(($pago / $total) * 100, 2);
    }

    public static function aplicarFiltros($dados, array $filtros)
    {
        $resultado = $dados;

        if (isset($filtros['status']) && $filtros['status']) {
            $resultado = $resultado->where('status', $filtros['status']);
        }

        if (isset($filtros['valor_min']) && $filtros['valor_min']) {
            $resultado = $resultado->where('valor', '>=', $filtros['valor_min']);
        }

        if (isset($filtros['valor_max']) && $filtros['valor_max']) {
            $resultado = $resultado->where('valor', '<=', $filtros['valor_max']);
        }

        return $resultado;
    }

    public static function agruparPorStatus(Collection $dados)
    {
        return $dados->groupBy('status')->map(function ($grupo) {
            return [
                'quantidade' => $grupo->count(),
                'total' => $grupo->sum('valor'),
                'items' => $grupo,
            ];
        });
    }

    public static function calcularFluxoCaixa(array $resumo)
    {
        $aReceber = $resumo['receber']['pendente'] ?? 0;
        $aPagar = $resumo['pagar']['pendente'] ?? 0;

        return [
            'fluxo_positivo' => $aReceber - $aPagar,
            'a_receber' => $aReceber,
            'a_pagar' => $aPagar,
            'status' => ($aReceber - $aPagar) >= 0 ? 'superávit' : 'déficit',
        ];
    }

    public static function renderizarTabelaPagar($dados)
    {
        $html = '<table class="table table-striped">';
        $html .= '<thead><tr><th>Fornecedor</th><th>Descrição</th><th>Valor</th><th>Vencimento</th><th>Status</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($dados as $item) {
            $badge = self::statusBadge($item->status);
            $html .= '<tr>';
            $html .= '<td>' . ($item->fornecedor->nome_fornecedor ?? 'N/A') . '</td>';
            $html .= '<td>' . $item->descricao . '</td>';
            $html .= '<td>' . self::formatarValor($item->valor) . '</td>';
            $html .= '<td>' . self::formatarData($item->data_vencimento) . '</td>';
            $html .= '<td><span class="' . $badge['classe'] . '">' . $badge['texto'] . '</span></td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    public static function renderizarTabelaReceber($dados)
    {
        $html = '<table class="table table-striped">';
        $html .= '<thead><tr><th>Cliente</th><th>Descrição</th><th>Valor</th><th>Vencimento</th><th>Status</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($dados as $item) {
            $badge = self::statusBadge($item->status);
            $html .= '<tr>';
            $html .= '<td>' . ($item->cliente->nome_cliente ?? 'N/A') . '</td>';
            $html .= '<td>' . $item->descricao . '</td>';
            $html .= '<td>' . self::formatarValor($item->valor) . '</td>';
            $html .= '<td>' . self::formatarData($item->data_vencimento) . '</td>';
            $html .= '<td><span class="' . $badge['classe'] . '">' . $badge['texto'] . '</span></td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }
}
