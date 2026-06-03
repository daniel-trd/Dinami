<?php

namespace Database\Factories;

use App\Models\EstoqueMovimentacao;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstoqueMovimentacaoFactory extends Factory
{
    protected $model = EstoqueMovimentacao::class;

    /**
     * Define os valores padrão do modelo.
     */
    public function definition()
    {
        $tipo = $this->faker->randomElement([
            EstoqueMovimentacao::TIPO_ENTRADA,
            EstoqueMovimentacao::TIPO_SAIDA,
            EstoqueMovimentacao::TIPO_AJUSTE,
        ]);

        return [
            'id_produto' => Produto::factory(),
            'tipo' => $tipo,
            'quantidade' => $this->faker->numberBetween(1, 50),
            'motivo' => $this->faker->sentence(),
            'id_usuario' => User::factory(),
            'observacoes' => $this->faker->optional()->sentence(),
            'data_movimentacao' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }

    public function entrada()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo' => EstoqueMovimentacao::TIPO_ENTRADA,
                'motivo' => 'Compra - NF #' . $this->faker->numerify('######'),
            ];
        });
    }

    public function saida()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo' => EstoqueMovimentacao::TIPO_SAIDA,
                'motivo' => 'Venda - Pedido #' . $this->faker->numerify('#####'),
            ];
        });
    }

    public function ajuste()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo' => EstoqueMovimentacao::TIPO_AJUSTE,
                'motivo' => 'Ajuste de Inventário',
            ];
        });
    }
}
