<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasReceber extends Model
{
    use HasFactory;

    protected $table = 'contas_receber';

    protected $fillable = [
        'descricao',
        'valor',
        'cliente',
        'data_vencimento',
        'data_cadastro',
        'data_pagamento',
        'status',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_cadastro' => 'date',
        'data_pagamento' => 'date',
    ];

    const STATUS_PENDENTE = 'pendente';
    const STATUS_RECEBIDO = 'recebido';
}