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
        Schema::create('estoques', function (Blueprint $table) {
            $table->id('id_estoque');
            $table->unsignedBigInteger('id_produto');
            $table->integer('quantidade')->default(0);
            $table->decimal('preco_custo', 10, 2)->nullable();
            $table->decimal('preco_venda', 10, 2)->nullable();
            $table->date('data_entrada')->nullable();
            $table->string('lote', 50)->nullable();
            $table->timestamp('vencimento')->nullable();
            $table->timestamps();

            $table->foreign('id_produto')->references('id_produto')->on('produtos')->onDelete('cascade');
            $table->index(['id_produto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};
