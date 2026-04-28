<?php

namespace Database\Factories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientesFactory extends Factory
{
    // Modelo relacionado à factory
    protected $model = Clientes::class;

    /**
     * Define os valores padrão do modelo.
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'data_cadastro' => $this->faker->date(),
            'status' => $this->faker->randomElement([Clientes::STATUS_ATIVO, Clientes::STATUS_INATIVO]),
        ];
    }
}
