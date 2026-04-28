<?php

namespace Database\Factories;

use App\Models\Fornecedores;
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedoresFactory extends Factory
{
    // Modelo relacionado à factory
    protected $model = Fornecedores::class;

    /**
     * Define os valores padrão do modelo.
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'data_cadastro' => $this->faker->date(),
            'status' => $this->faker->randomElement([Fornecedores::STATUS_ATIVO, Fornecedores::STATUS_INATIVO]),
        ];
    }
}