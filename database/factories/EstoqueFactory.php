<?php

namespace Database\Factories;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstoqueFactory extends Factory
{
    protected $model = Estoque::class;

    /**
     * Define os valores padrão do modelo.
     */
    public function definition()
    {
        return [
            'id_produto' => Produto::factory(),
            'quantidade' => $this->faker->numberBetween(1, 100),
            'preco_custo' => $this->faker->numberBetween(5, 500) . '.' . $this->faker->numerify('##'),
            'preco_venda' => $this->faker->numberBetween(10, 800) . '.' . $this->faker->numerify('##'),
            'data_entrada' => $this->faker->dateTimeBetween('-1 year'),
            'lote' => $this->faker->bothify('LOTE-####-??'),
            'vencimento' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
        ];
    }

    public function comSemEstoque()
    {
        return $this->state(function (array $attributes) {
            return [
                'quantidade' => 0,
            ];
        });
    }

    public function expirado()
    {
        return $this->state(function (array $attributes) {
            return [
                'vencimento' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            ];
        });
    }
}
