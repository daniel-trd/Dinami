<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContasPagar;
use App\Models\ContasReceber;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // A pagar (somente pendentes)
        $pagar = ContasPagar::where('status', 'pendente')->sum('valor');

        // A receber (somente pendentes)
        $receber = ContasReceber::where('status', 'pendente')->sum('valor');

        // Total pago (saída real)
        $pago = ContasPagar::where('status', 'pago')->sum('valor');

        // Total recebido (entrada real)
        $recebido = ContasReceber::where('status', 'recebido')->sum('valor');

        // Saldo atual
        $saldoAtual = $pago - $recebido;

        // Lucro (entrada - saída)
        $lucro = $saldoAtual;

        return view('dashboard', compact(
            'saldoAtual',
            'receber',
            'pagar',
            'lucro'
        ));
    }
}
