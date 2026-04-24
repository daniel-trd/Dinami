<?php

namespace App\Http\Controllers;

use App\Models\ContasReceber;
use Illuminate\Http\Request;

class ContaReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = ContasReceber::all();

        return view('contas_receber.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contas_receber.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'cliente' => 'nullable',
            'data_vencimento' => 'nullable',
            'data_pagamento' => 'nullable'
        ]);

        ContasReceber::create($request->all());

        return redirect()
            ->route('contas_receber.index')
            ->with('success', 'Conta criada com sucesso');
    }

    public function show(string $id)
    {
        $contas = ContasReceber::findOrFail($id);
        return view('contas_receber.show', compact('contas'));
    }

    public function edit(string $id)
    {
        $contas = ContasReceber::findOrFail($id);
        return view('contas_receber.edit', compact('contas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'descricao' => 'required|max:255',
            'valor' => 'nullable',
            'cliente' => 'nullable',
            'data_vencimento' => 'nullable',
            'data_pagamento' => 'nullable'
        ]);

        $contas = ContasReceber::findOrFail($id);
        $contas->update($request->all());

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
