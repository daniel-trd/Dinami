<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'estoque_movimentacoes';

    protected $primaryKey = 'id_movimentacao';

    protected $fillable = [
        'id_produto',
        'tipo',
        'quantidade',
        'motivo',
        'id_usuario',
        'observacoes',
        'data_movimentacao',
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'data_movimentacao' => 'date',
    ];

    const TIPO_ENTRADA = 'entrada';
    const TIPO_SAIDA = 'saida';
    const TIPO_AJUSTE = 'ajuste';

    // Relações
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    // Scopes
    public function scopeEntradas($query)
    {
        return $query->where('tipo', self::TIPO_ENTRADA);
    }

    public function scopeSaidas($query)
    {
        return $query->where('tipo', self::TIPO_SAIDA);
    }

    public function scopeAjustes($query)
    {
        return $query->where('tipo', self::TIPO_AJUSTE);
    }
}
