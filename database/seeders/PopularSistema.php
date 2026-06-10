<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Clientes;
use App\Models\Fornecedores;
use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\Produto;
use App\Models\Estoque;
use App\Models\EstoqueMovimentacao;

class PopularSistema extends Seeder
{
    public function run(): void
    {
        try {

            DB::beginTransaction();

            $this->command->info('=============================');
            $this->command->info('==== INICIANDO POPULAÇÃO ====');
            $this->command->info('=============================');

            $total = 10;

            $this->command->info('👤 Criando usuários...');

            $user = [
                'name' => 'Daniel',
                'email' => 'daniel@adm.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ];

            User::insert($user);

            $this->command->line('[INFO] - Criando usuário adm...');
            $this->command->line(str_repeat('-', 60));

            collect([
                [
                    'nome' => 'Clientes',
                    'total' => $total,
                    'factory' => fn() => Clientes::factory()->create(),
                ],
                [
                    'nome' => 'Fornecedores',
                    'total' => $total,
                    'factory' => fn() => Fornecedores::factory()->create(),
                ],
                [
                    'nome' => 'Contas a Pagar',
                    'total' => $total,
                    'factory' => fn() => ContasPagar::factory()->create(),
                ],
                [
                    'nome' => 'Contas a Receber',
                    'total' => $total,
                    'factory' => fn() => ContasReceber::factory()->create(),
                ],
                [
                    'nome' => 'Produtos',
                    'total' => $total,
                    'factory' => fn() => Produto::factory()->create(),
                ],
                [
                    'nome' => 'Estoque',
                    'total' => $total,
                    'factory' => fn() => Estoque::factory()->create(),
                ],
                [
                    'nome' => 'Movimentações de Estoque',
                    'total' => $total,
                    'factory' => fn() => EstoqueMovimentacao::factory()->create(),
                ],
            ])->each(function ($config) {

                $this->command->info("Criando {$config['nome']}...");

                collect(range(1, $config['total']))
                    ->each(function ($i) use ($config) {

                        $registro = $config['factory']();
                    });
            });

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            $this->command->error('❌ ERRO:');
            $this->command->error($e->getMessage());

            throw $e;
        }
    }
}
