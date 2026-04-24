<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasPagar extends Model
{
    use HasFactory;

    // Tabela relacionada (opcional se seguir convenção)
    protected $table = 'contas_pagar';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'descricao',
        'valor',
        'fornecedor',
        'data_vencimento',
        'data_cadastro',
        'data_pagamento',
        'status',
    ];

    // Casting de tipos
    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_cadastro' => 'date',
        'data_pagamento' => 'date',
    ];

    // Status padrão (opcional helper)
    const STATUS_PENDENTE = 'pendente';
    const STATUS_PAGO = 'pago';
}