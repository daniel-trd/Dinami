<?php

namespace Database\Factories;

use App\Models\ContasPagar;
use App\Models\Fornecedores;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContasPagarFactory extends Factory
{
    protected $model = ContasPagar::class;

    public function definition()
    {
        return [
            'id_fornecedor' => Fornecedores::factory(),
            'descricao' => $this->faker->sentence(3),
            'valor' => $this->faker->randomFloat(2, 100, 5000),
            'data_vencimento' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'data_cadastro' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'data_pagamento' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement([ContasPagar::STATUS_PENDENTE, ContasPagar::STATUS_PAGO]),
        ];
    }
}