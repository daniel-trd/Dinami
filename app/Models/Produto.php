<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $primaryKey = 'id_produto';

    protected $fillable = [
        'codigo_barras',
        'nome',
        'preco',
        'marca',
        'descricao',
        'unidade',
        'controla_estoque',
        'estoque_minimo',
        'estoque_maximo',
        'status',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'estoque_minimo' => 'integer',
        'estoque_maximo' => 'integer',
        'controla_estoque' => 'boolean',
    ];

    const STATUS_ATIVO = 'ativo';
    const STATUS_INATIVO = 'inativo';

    // Relações
    public function estoques()
    {
        return $this->hasMany(Estoque::class, 'id_produto', 'id_produto');
    }

    public function movimentacoes()
    {
        return $this->hasMany(EstoqueMovimentacao::class, 'id_produto', 'id_produto');
    }

    // Getters
    public function estoqueTotalAttribute()
    {
        return $this->estoques()->sum('quantidade') ?? 0;
    }
}
