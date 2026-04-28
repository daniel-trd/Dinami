<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $perPage = $request->get('per_page', 10);

        $clientes = Clientes::query()
            ->when($status === 'ativo', fn($q) => $q->where('status', 'ativo'))
            ->when($status === 'inativo', fn($q) => $q->where('status', 'inativo'))
            ->when(!$status, fn($q) => $q->where('status', 'ativo'))
            ->paginate($perPage)
            ->appends($request->query()); // mantém filtros

        return view('cliente.index', compact('clientes', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' =>  'required|max:255',
            'email' => 'unique:cliente,email',
            'telefone' => 'nullable'
        ]);

        Clientes::create($request->all());

        return redirect()->route('cliente.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clientes = Clientes::findOrFail($id);
        return view('clientes.show', compact('clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clientes = Clientes::findOrFail($id);
        return view('cliente.edit', compact('clientes'));
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
                Rule::unique('cliente', 'email')->ignore($id, 'id_cliente')
            ],
            'telefone' => 'nullable'
        ]);

        $clientes = Clientes::findOrFail($id);
        $clientes->update($request->all());

        return redirect()
            ->route('cliente.index')
            ->with('success', 'Cliente atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function toggleStatus($id)
    {
        $cliente = Clientes::findOrFail($id);

        $cliente->status = $cliente->status === 'ativo' ? 'inativo' : 'ativo';
        $cliente->save();

        return back();
    }
}
