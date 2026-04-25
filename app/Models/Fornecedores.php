<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedores extends Model
{
    use HasFactory;

    protected $table = 'fornecedor';

    protected $primaryKey = 'id_fornecedor';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_cadastro',
        'status',
    ];

    // Casting de tipos
    protected $casts = [
        'data_cadastro' => 'date',
    ];

    // Status padrão (opcional helper)
    const STATUS_ATIVO = 'ativo';
    const STATUS_INATIVO = 'inativo';
}
