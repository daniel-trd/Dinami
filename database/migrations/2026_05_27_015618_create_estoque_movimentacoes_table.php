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
        Schema::create('estoque_movimentacoes', function (Blueprint $table) {
            $table->id('id_movimentacao');
            $table->unsignedBigInteger('id_produto');
            $table->enum('tipo', ['entrada', 'saida', 'ajuste'])->default('entrada');
            $table->integer('quantidade');
            $table->string('motivo', 255)->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->text('observacoes')->nullable();
            $table->date('data_movimentacao')->default(now());
            $table->timestamps();

            $table->foreign('id_produto')->references('id_produto')->on('produtos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            $table->index(['id_produto']);
            $table->index(['data_movimentacao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque_movimentacoes');
    }
};
