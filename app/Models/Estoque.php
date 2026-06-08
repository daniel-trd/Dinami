<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoques';

    protected $primaryKey = 'id_estoque';

    protected $fillable = [
        'id_produto',
        'quantidade',
        'preco_custo',
        'preco_venda',
        'data_entrada',
        'lote',
        'vencimento',
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'preco_custo' => 'decimal:2',
        'preco_venda' => 'decimal:2',
        'data_entrada' => 'date',
        'vencimento' => 'datetime',
    ];

    // Relações
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    // Scopes
    public function scopeLow($query)
    {
        return $query->whereColumn('quantidade', '<', 'produto.estoque_minimo');
    }

    public function scopeHigh($query)
    {
        return $query->whereColumn('quantidade', '>', 'produto.estoque_maximo');
    }
}
