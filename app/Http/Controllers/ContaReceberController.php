<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContasReceber;
use App\Models\Clientes;

class ContaReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = ContasReceber::with('cliente')
            ->orderBy('id_conta_receber', 'asc')
            ->get();

        return view('contas_receber.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Clientes::all();

        return view('contas_receber.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'status' => 'nullable',
            'data_vencimento' => 'nullable',
            'data_pagamento' => 'nullable'
        ]);

        ContasReceber::create($request->only([
            'id_cliente',
            'descricao',
            'valor',
            'status',
            'data_vencimento',
            'data_pagamento'
        ]));

        return redirect()
            ->route('contas_receber.index')
            ->with('success', 'Conta criada com sucesso');
    }

    public function show(string $id)
    {
        $contas = ContasReceber::with('cliente')->findOrFail($id);
        return view('contas_receber.show', compact('contas'));
    }

    public function edit(string $id)
    {
        $contas = ContasReceber::with('cliente')->findOrFail($id);
        return view('contas_receber.edit', compact('contas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'status' => 'nullable',
            'data_vencimento' => 'nullable',
            'data_pagamento' => 'nullable'
        ]);

        $contas = ContasReceber::findOrFail($id);
        $contas->update($request->only([
            'id_cliente',
            'descricao',
            'valor',
            'status',
            'data_vencimento',
            'data_pagamento'
        ]));

        return redirect()
            ->route('contas_receber.index')
            ->with('success', 'Conta a Receber atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contas = ContasReceber::findOrFail($id);
        $contas->delete();

        return redirect()
            ->route('contas_receber.index')
            ->with('success', 'Conta a Receber removida com sucesso');
    }
}
