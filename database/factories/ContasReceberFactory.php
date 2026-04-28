<?php

namespace Database\Factories;

use App\Models\ContasReceber;
use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContasReceberFactory extends Factory
{
    protected $model = ContasReceber::class;

    public function definition()
    {
        return [
            'id_cliente' => Clientes::factory(),
            'descricao' => $this->faker->sentence(3),
            'valor' => $this->faker->randomFloat(2, 100, 5000),
            'data_vencimento' => $this->faker->dateTimeBetween('-1 month', '+3 months'),
            'data_cadastro' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'data_pagamento' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement([ContasReceber::STATUS_PENDENTE, ContasReceber::STATUS_RECEBIDO]),
        ];
    }
}
