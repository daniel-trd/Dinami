<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\Clientes;
use App\Models\Fornecedores;
use App\Models\Produto;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.index', [
            'pagar' => ContasPagar::where('status', 'pendente')->sum('valor'),
            'receber' => ContasReceber::where('status', 'pendente')->sum('valor'),
            'totalClientes' => Clientes::where('status', 'ativo')->count(),
            'totalProdutos' => Produto::where('status', 'ativo')->count(),
            'ultimasContasReceber' => ContasReceber::with('cliente')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'ultimasContasPagar' => ContasPagar::with('fornecedor')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ]);
    }
}
