<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    /**
     * Define os valores padrão do modelo.
     */
    public function definition()
    {
        $unidades = ['UN', 'CX', 'KG', 'L', 'M', 'M2'];

        return [
            'codigo_barras' => $this->faker->unique()->numerify('################'),
            'nome' => $this->faker->words(3, true),
            'preco' => $this->faker->numberBetween(10, 1000) . '.' . $this->faker->numerify('##'),
            'marca' => $this->faker->words(2, true),
            'descricao' => $this->faker->sentence(),
            'unidade' => $this->faker->randomElement($unidades),
            'controla_estoque' => true,
            'estoque_minimo' => $this->faker->numberBetween(5, 20),
            'estoque_maximo' => $this->faker->numberBetween(50, 200),
            'status' => Produto::STATUS_ATIVO,
        ];
    }

    public function inativo()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Produto::STATUS_INATIVO,
            ];
        });
    }
}
