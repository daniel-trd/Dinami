<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use Illuminate\Http\Request;
use App\Models\Fornecedores;
use PhpParser\Node\NullableType;

class ContaPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = ContasPagar::with('fornecedor')
            ->orderBy('id_conta_pagar', 'asc')
            ->get();

        return view('contas_pagar.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fornecedores = Fornecedores::all();
        return view('contas_pagar.create', compact('fornecedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_fornecedor' => 'required|exists:fornecedor,id_fornecedor',
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'status' => 'nullable',
            'data_vencimento' => 'nullable'
        ]);

        ContasPagar::create($request->only([
            'descricao',
            'id_fornecedor',
            'valor',
            'status',
            'data_vencimento',
            'data_pagamento'
        ]));

        return redirect()
            ->route('contas_pagar.index')
            ->with('success', 'Conta criada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contas = ContasPagar::with('fornecedor')->findOrFail($id);
        return view('contas_pagar.show', compact('contas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contas = ContasPagar::with('fornecedor')->findOrFail($id);
        return view('contas_pagar.edit', compact('contas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'status' => 'nullable',
            'id_fornecedor' => 'required|exists:fornecedor,id_fornecedor',
            'data_vencimento' => 'nullable'
        ]);

        $contas = ContasPagar::findOrFail($id);
        $contas->update($request->only([
            'descricao',
            'id_fornecedor',
            'valor',
            'status',
            'data_vencimento',
            'data_pagamento'
        ]));

        return redirect()
            ->route('contas_pagar.index')
            ->with('success', 'Conta a Pagar atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contas = ContasPagar::findOrFail($id);
        $contas->delete();

        return redirect()
            ->route('contas_pagar.index')
            ->with('success', 'Conta a Pagar removida com sucesso');
    }
}
