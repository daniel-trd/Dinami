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
        $pagar = ContasPagar::where('status', 'pendente')->sum('valor');

        $receber = ContasReceber::where('status', 'pendente')->sum('valor');

        $novosClientes = Clientes::where('data_cadastro', '>=', now()->subMonth())->count();

        $novosFornecedores = Fornecedores::where('data_cadastro', '>=', now()->subMonth())->count();

        $pagos = ContasPagar::where('status', 'pago')->sum('valor');

        $recebidos = ContasReceber::where('status', 'recebido')->sum('valor');

        return view('dashboard.index', compact(
            'receber',
            'pagar',
            'novosClientes',
            'novosFornecedores',
            'pagos',
            'recebidos'
        ));
    }
}
