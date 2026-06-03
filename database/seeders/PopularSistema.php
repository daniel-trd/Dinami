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

            echo "\n============================\n";
            echo "🚀 INICIANDO POPULAÇÃO\n";
            echo "============================\n\n";

            // ================= USERS =================
            $totalUsers = 5;
            echo "👤 Criando usuários...\n";

            for ($i = 1; $i <= $totalUsers; $i++) {

                $user = User::factory()->create();
                $percent = ($i / $totalUsers) * 100;

                echo sprintf(
                    "(%02d/%02d) - (%3.0f%%) - User | Nome: %-20s | Email: %-25s\n",
                    $i,
                    $totalUsers,
                    $percent,
                    $user->name,
                    $user->email
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= CLIENTES =================
            $totalClientes = 100;
            echo "👥 Criando clientes...\n";

            for ($i = 1; $i <= $totalClientes; $i++) {

                $cliente = Clientes::factory()->create();
                $percent = ($i / $totalClientes) * 100;

                echo sprintf(
                    "(%04d/%04d) - (%3.0f%%) - Cliente | Nome: %-20s | Tel: %-15s\n",
                    $i,
                    $totalClientes,
                    $percent,
                    $cliente->nome,
                    $cliente->telefone
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= FORNECEDORES =================
            $totalFornecedores = 10;
            echo "🏢 Criando fornecedores...\n";

            for ($i = 1; $i <= $totalFornecedores; $i++) {

                $f = Fornecedores::factory()->create();
                $percent = ($i / $totalFornecedores) * 100;

                echo sprintf(
                    "(%02d/%02d) - (%3.0f%%) - Fornecedor | Nome: %-20s | Email: %-15s | Tel: %-15s | Status: %-10s\n",
                    $i,
                    $totalFornecedores,
                    $percent,
                    $f->nome,
                    $f->email,
                    $f->telefone,
                    $f->status
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= CONTAS PAGAR =================
            $totalPagar = 100;
            echo "💸 Criando contas a pagar...\n";

            for ($i = 1; $i <= $totalPagar; $i++) {

                $cp = ContasPagar::factory()->create();
                $percent = ($i / $totalPagar) * 100;

                echo sprintf(
                    "(%04d/%04d) - (%3.0f%%) - Conta a Pagar | Valor: %-10s | Status: %-10s | Fornecedor: %-20s | Vencimento: %-10s | Pagamento: %-10s | \n",
                    $i,
                    $totalPagar,
                    $percent,
                    $cp->valor,
                    $cp->status,
                    $cp->fornecedor->nome,
                    $cp->data_vencimento->format('d/m/Y'),
                    $cp->data_pagamento ? $cp->data_pagamento->format('d/m/Y') : 'N/A',
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= CONTAS RECEBER =================
            $totalReceber = 100;
            echo "💰 Criando contas a receber...\n";

            for ($i = 1; $i <= $totalReceber; $i++) {

                $cr = ContasReceber::factory()->create();
                $percent = ($i / $totalReceber) * 100;

                echo sprintf(
                    "(%04d/%04d) - (%3.0f%%) - Conta a Receber | Valor: %-10s | Status: %-10s | Cliente: %-20s | Vencimento: %-10s | Pagamento: %-10s | \n",
                    $i,
                    $totalReceber,
                    $percent,
                    $cr->valor,
                    $cr->status,
                    $cr->cliente->nome,
                    $cr->data_vencimento->format('d/m/Y'),
                    $cr->data_pagamento ? $cr->data_pagamento->format('d/m/Y') : 'N/A',
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= PRODUTOS =================
            $totalProdutos = 50;
            echo "📦 Criando produtos...\n";

            for ($i = 1; $i <= $totalProdutos; $i++) {

                $produto = Produto::factory()->create();
                $percent = ($i / $totalProdutos) * 100;

                echo sprintf(
                    "(%02d/%02d) - (%3.0f%%) - Produto | Nome: %-20s | Código: %-18s | Preço: %-10s\n",
                    $i,
                    $totalProdutos,
                    $percent,
                    $produto->nome,
                    $produto->codigo_barras,
                    'R$ ' . number_format($produto->preco, 2, ',', '.')
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= ESTOQUES =================
            $totalEstoque = 100;
            echo "📊 Criando entradas de estoque...\n";

            for ($i = 1; $i <= $totalEstoque; $i++) {

                $estoque = Estoque::factory()->create();
                $percent = ($i / $totalEstoque) * 100;

                echo sprintf(
                    "(%03d/%03d) - (%3.0f%%) - Estoque | Produto: %-20s | Qtd: %-5s | Preço: %-10s\n",
                    $i,
                    $totalEstoque,
                    $percent,
                    Str::limit($estoque->produto->nome, 20),
                    $estoque->quantidade,
                    'R$ ' . number_format($estoque->preco_custo, 2, ',', '.')
                );
            }

            echo str_repeat('-', 60) . "\n\n";


            // ================= MOVIMENTAÇÕES =================
            $totalMovimentacoes = 100;
            echo "🔄 Criando movimentações de estoque...\n";

            for ($i = 1; $i <= $totalMovimentacoes; $i++) {

                $movimentacao = EstoqueMovimentacao::factory()->create();
                $percent = ($i / $totalMovimentacoes) * 100;

                $tipoLabel = match($movimentacao->tipo) {
                    'entrada' => '📥 Entrada',
                    'saida' => '📤 Saída',
                    'ajuste' => '🔧 Ajuste',
                    default => 'Desconhecido'
                };

                echo sprintf(
                    "(%03d/%03d) - (%3.0f%%) - Movimentação | Tipo: %-10s | Produto: %-20s | Qtd: %-5s\n",
                    $i,
                    $totalMovimentacoes,
                    $percent,
                    $tipoLabel,
                    Str::limit($movimentacao->produto->nome, 20),
                    $movimentacao->quantidade
                );
            }

            echo "\n============================\n";
            echo "✅ FINALIZADO COM SUCESSO!\n";
            echo "============================\n\n";

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            echo "\n❌ ERRO:\n";
            echo $e->getMessage() . "\n";

            throw $e;
        }
    }
}