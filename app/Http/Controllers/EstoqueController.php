<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Estoque;
use App\Models\EstoqueMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $estoque = $request->get('estoque');
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $produtos = Produto::query()
            ->with('estoques')

            ->when($status === 'ativo', function ($q) {
                $q->where('status', 'ativo');
            })

            ->when($status === 'inativo', function ($q) {
                $q->where('status', 'inativo');
            })

            ->when(!$status, function ($q) {
                $q->where('status', 'ativo');
            })

            ->when($estoque === 'baixo', function ($q) {
                $q->whereRaw('(SELECT COALESCE(SUM(quantidade), 0) FROM estoques WHERE estoques.id_produto = produtos.id_produto) < estoque_minimo');
            })

            ->when($estoque === 'alto', function ($q) {
                $q->whereRaw('(SELECT COALESCE(SUM(quantidade), 0) FROM estoques WHERE estoques.id_produto = produtos.id_produto) > estoque_maximo');
            })

            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('nome', 'ILIKE', "%{$search}%")
                        ->orWhere('codigo_barras', 'ILIKE', "%{$search}%")
                        ->orWhere('marca', 'ILIKE', "%{$search}%");
                });
            })

            ->paginate($perPage)
            ->appends($request->query());

        return view('estoque.index', compact('produtos', 'status', 'estoque', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estoque.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_barras' => 'required|unique:produtos,codigo_barras|max:50',
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'marca' => 'nullable|max:50',
            'descricao' => 'nullable',
            'unidade' => 'required|max:20',
            'controla_estoque' => 'nullable|boolean',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_maximo' => 'required|integer|min:0',
        ]);

        $produto = Produto::create($request->all());

        return redirect()
            ->route('estoque.show', $produto)
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $estoque)
    {
        $estoque->load('estoques', 'movimentacoes.usuario');
        $movimentacoes = $estoque->movimentacoes()
            ->latest('data_movimentacao')
            ->paginate(15);

        $totalEmEstoque = $estoque->estoques()->sum('quantidade');
        $valorTotalEstoque = $estoque->estoques()
            ->selectRaw('SUM(quantidade * preco_custo) as total')
            ->value('total') ?? 0;

        return view('estoque.show', compact('estoque', 'movimentacoes', 'totalEmEstoque', 'valorTotalEstoque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $estoque)
    {
        return view('estoque.edit', compact('estoque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $estoque)
    {
        $request->validate([
            'codigo_barras' => [
                'required',
                'max:50',
                Rule::unique('produtos', 'codigo_barras')->ignore($estoque->id_produto, 'id_produto')
            ],
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'marca' => 'nullable|max:50',
            'descricao' => 'nullable',
            'unidade' => 'required|max:20',
            'controla_estoque' => 'nullable|boolean',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_maximo' => 'required|integer|min:0',
        ]);

        $estoque->update($request->all());

        return redirect()
            ->route('estoque.show', $estoque)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $estoque)
    {
        $estoque->delete();

        return redirect()
            ->route('estoque.index')
            ->with('success', 'Produto removido com sucesso!');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Produto $estoque)
    {
        $estoque->status = $estoque->status === 'ativo' ? 'inativo' : 'ativo';
        $estoque->save();

        return back()->with('success', 'Status atualizado com sucesso!');
    }

    /**
     * Show form for new stock movement
     */
    public function createMovimentacao(Produto $estoque)
    {
        return view('estoque.movimentacao', compact('estoque'));
    }

    /**
     * Store new stock movement
     */
    public function storeMovimentacao(Request $request, Produto $estoque)
    {
        $request->validate([
            'tipo' => 'required|in:entrada,saida,ajuste',
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'nullable|max:255',
            'observacoes' => 'nullable',
            'data_movimentacao' => 'required|date',
        ]);

        $dados = $request->all();
        $dados['id_produto'] = $estoque->id_produto;
        $dados['id_usuario'] = auth()->id();

        // Atualizar estoque automaticamente
        if ($request->tipo === EstoqueMovimentacao::TIPO_ENTRADA) {
            $saldoAtual = Estoque::where('id_produto', $estoque->id_produto)->sum('quantidade');
            Estoque::create([
                'id_produto' => $estoque->id_produto,
                'quantidade' => $request->quantidade,
                'preco_custo' => $request->preco_custo ?? $estoque->preco,
                'data_entrada' => $request->data_movimentacao,
            ]);
        } elseif ($request->tipo === EstoqueMovimentacao::TIPO_SAIDA) {
            // Deduzir do estoque mais antigo (FIFO)
            $estoques = Estoque::where('id_produto', $estoque->id_produto)
                ->where('quantidade', '>', 0)
                ->orderBy('data_entrada')
                ->get();

            $quantidadeRestante = $request->quantidade;
            foreach ($estoques as $item) {
                if ($quantidadeRestante <= 0) break;

                $deduzir = min($item->quantidade, $quantidadeRestante);
                $item->quantidade -= $deduzir;
                $item->save();
                $quantidadeRestante -= $deduzir;
            }
        } elseif ($request->tipo === EstoqueMovimentacao::TIPO_AJUSTE) {
            // Ajuste manual - recalcular saldo total
            $saldoAtual = Estoque::where('id_produto', $estoque->id_produto)->sum('quantidade');
            $diferenca = $request->quantidade - $saldoAtual;

            if ($diferenca > 0) {
                Estoque::create([
                    'id_produto' => $estoque->id_produto,
                    'quantidade' => $diferenca,
                    'data_entrada' => $request->data_movimentacao,
                ]);
            } elseif ($diferenca < 0) {
                $estoques = Estoque::where('id_produto', $estoque->id_produto)
                    ->where('quantidade', '>', 0)
                    ->orderBy('data_entrada', 'desc')
                    ->get();

                $quantidadeRestante = abs($diferenca);
                foreach ($estoques as $item) {
                    if ($quantidadeRestante <= 0) break;

                    $deduzir = min($item->quantidade, $quantidadeRestante);
                    $item->quantidade -= $deduzir;
                    $item->save();
                    $quantidadeRestante -= $deduzir;
                }
            }
        }

        EstoqueMovimentacao::create($dados);

        return redirect()
            ->route('estoque.show', $estoque)
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    /**
     * Show stock history
     */
    public function historico(Produto $estoque)
    {
        $movimentacoes = EstoqueMovimentacao::where('id_produto', $estoque->id_produto)
            ->with('usuario')
            ->latest('data_movimentacao')
            ->paginate(20);

        return view('estoque.historico', compact('estoque', 'movimentacoes'));
    }
}
