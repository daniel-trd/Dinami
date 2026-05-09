<?php

namespace App\Http\Controllers;

use App\Models\ContasPagar;
use Illuminate\Http\Request;
use App\Models\Fornecedores;
use Illuminate\Validation\Rule;

class ContaPagarController extends Controller
{
    /**
     * LISTAGEM
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        $perPage = $request->get('per_page', 10);

        $search = $request->get('search');

        $contas = ContasPagar::query()

            /*
            |--------------------------------------------------------------------------
            | RELACIONAMENTO
            |--------------------------------------------------------------------------
            */

            ->with('fornecedor')

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            ->when($status === 'pago', function ($q) {

                $q->where('status', 'pago');
            })

            ->when($status === 'pendente', function ($q) {

                $q->where('status', 'pendente');
            })

            /*
            |--------------------------------------------------------------------------
            | BUSCA
            |--------------------------------------------------------------------------
            */

            ->when($search, function ($q) use ($search) {

                $q->where(function ($query) use ($search) {

                    /*
                    |--------------------------------------------------------------------------
                    | Busca descrição
                    |--------------------------------------------------------------------------
                    */

                    $query->where('descricao', 'ILIKE', "%{$search}%")

                        /*
                        |--------------------------------------------------------------------------
                        | Busca fornecedor
                        |--------------------------------------------------------------------------
                        */

                        ->orWhereHas('fornecedor', function ($fornecedor) use ($search) {

                            $fornecedor->where(
                                'nome',
                                'ILIKE',
                                "%{$search}%"
                            );
                        });
                });
            })

            ->paginate($perPage)

            ->appends($request->query());

        return view(
            'contas_pagar.index',
            compact('contas', 'status', 'search')
        );
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('contas_pagar.create');
    }

    /**
     * AUTOCOMPLETE FORNECEDOR
     */
    public function search(Request $request)
    {
        $search = $request->get('q');

        $fornecedores = Fornecedores::query()

            ->when($search, function ($q) use ($search) {

                $q->where('nome', 'ILIKE', "%{$search}%");
            })

            ->limit(20)

            ->get([
                'id_fornecedor as id',
                'nome'
            ]);

        return response()->json($fornecedores);
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAÇÃO
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'id_fornecedor' => [
                'required',
                'exists:fornecedor,id_fornecedor'
            ],

            'descricao' => [
                'required',
                'string',
                'max:255'
            ],

            'valor' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'required',
                Rule::in(['pendente', 'pago']),
            ],

            'data_vencimento' => [
                'required',
                'date'
            ],

            /*
            |--------------------------------------------------------------------------
            | Se pago, data pagamento obrigatória
            |--------------------------------------------------------------------------
            */

            'data_pagamento' => [
                'nullable',
                'date',
                Rule::requiredIf(
                    $request->status === 'pago'
                ),
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Se pendente, remove pagamento
        |--------------------------------------------------------------------------
        */

        if ($validated['status'] === 'pendente') {

            $validated['data_pagamento'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        ContasPagar::create($validated);

        return redirect()

            ->route('contas_pagar.index')

            ->with(
                'success',
                'Conta criada com sucesso'
            );
    }

    /**
     * SHOW
     */
    public function show(string $id)
    {
        $contas = ContasPagar::with('fornecedor')

            ->findOrFail($id);

        return view(
            'contas_pagar.show',
            compact('contas')
        );
    }

    /**
     * EDIT
     */
    public function edit(string $id)
    {
        $contas = ContasPagar::with('fornecedor')

            ->findOrFail($id);

        return view(
            'contas_pagar.edit',
            compact('contas')
        );
    }

    /**
     * UPDATE
     */
    public function update(Request $request, string $id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAÇÃO
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'id_fornecedor' => [
                'required',
                'exists:fornecedor,id_fornecedor'
            ],

            'descricao' => [
                'required',
                'string',
                'max:255'
            ],

            'valor' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'required',
                Rule::in(['pendente', 'pago']),
            ],

            'data_vencimento' => [
                'required',
                'date'
            ],

            'data_pagamento' => [
                'nullable',
                'date',
                Rule::requiredIf(
                    $request->status === 'pago'
                ),
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Se pendente, remove pagamento
        |--------------------------------------------------------------------------
        */

        if ($validated['status'] === 'pendente') {

            $validated['data_pagamento'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $contas = ContasPagar::findOrFail($id);

        $contas->update($validated);

        return redirect()

            ->route('contas_pagar.index')

            ->with(
                'success',
                'Conta a Pagar atualizada com sucesso'
            );
    }

    /**
     * DESTROY
     */
    public function destroy(string $id)
    {
        $contas = ContasPagar::findOrFail($id);

        $contas->delete();

        return redirect()

            ->route('contas_pagar.index')

            ->with(
                'success',
                'Conta a Pagar removida com sucesso'
            );
    }
}
