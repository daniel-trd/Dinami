<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        $fornecedores = Fornecedores::query()
            ->when($status === 'ativo', fn($q) => $q->where('status', 'ativo'))
            ->when($status === 'inativo', fn($q) => $q->where('status', 'inativo'))
            ->when(!$status, fn($q) => $q->where('status', 'ativo'))
            ->get();

        return view('fornecedor.index', compact('fornecedores', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' =>  'required|max:255',
            'email' => 'unique:fornecedor,email',
            'telefone' => 'nullable'
        ]);

        Fornecedores::create($request->all());

        return redirect()->route('fornecedor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fornecedores = Fornecedores::findOrFail($id);
        return view('fornecedor.show', compact('fornecedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fornecedores = Fornecedores::findOrFail($id);
        return view('fornecedor.edit', compact('fornecedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('fornecedor', 'email')->ignore($id, 'id_fornecedor')
            ],
            'telefone' => 'nullable'
        ]);

        $fornecedores = Fornecedores::findOrFail($id);
        $fornecedores->update($request->all());

        return redirect()
            ->route('fornecedor.index')
            ->with('success', 'Fornecedor atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function toggleStatus($id)
    {
        $fornecedor = Fornecedores::findOrFail($id);

        $fornecedor->status = $fornecedor->status === 'ativo' ? 'inativo' : 'ativo';
        $fornecedor->save();

        return back();
    }
}
