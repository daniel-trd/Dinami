<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fornecedores;

class ContasPagar extends Model
{
    use HasFactory;

    // Tabela relacionada (opcional se seguir convenção)
    protected $table = 'contas_pagar';

    protected $primaryKey = 'id_conta_pagar';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_fornecedor',
        'descricao',
        'valor',
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

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'id_fornecedor', 'id_fornecedor');
    }
}
