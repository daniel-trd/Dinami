<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueSaldo extends Model
{
    // Model read-only para relatórios e consultoria de saldo
    protected $table = 'estoques';

    protected $primaryKey = 'id_estoque';

    public $timestamps = false;

    protected $visible = [
        'id_estoque',
        'id_produto',
        'quantidade',
        'preco_custo',
        'preco_venda',
        'data_entrada',
        'lote',
    ];

    // Relações
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    // Scopes para consultas comuns
    public function scopeAtivo($query)
    {
        return $query->with('produto')
            ->whereHas('produto', function ($q) {
                $q->where('status', 'ativo');
            });
    }

    public function scopeComEstoque($query)
    {
        return $query->where('quantidade', '>', 0);
    }

    public function scopeSemEstoque($query)
    {
        return $query->where('quantidade', '<=', 0);
    }

    // Método para gerar saldo total
    public static function saldoTotalProduto($idProduto)
    {
        return self::where('id_produto', $idProduto)->sum('quantidade');
    }

    // Método para gerar valor total em estoque
    public static function valorTotalEstoque()
    {
        return self::selectRaw('SUM(quantidade * preco_custo) as total')->value('total') ?? 0;
    }
}
