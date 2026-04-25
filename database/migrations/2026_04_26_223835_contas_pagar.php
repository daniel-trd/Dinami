<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contas_pagar', function (Blueprint $table) {
            $table->id('id_conta_pagar');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->unsignedBigInteger('id_fornecedor');
            $table->date('data_vencimento');
            $table->date('data_cadastro')->default(now());
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['pendente', 'pago'])->default('pendente');
            $table->timestamps();

            $table->foreign('id_fornecedor')
                ->references('id_fornecedor')
                ->on('fornecedor')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas_pagar');
    }
};
