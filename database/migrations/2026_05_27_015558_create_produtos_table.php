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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('id_produto');
            $table->string('codigo_barras', 50)->unique();
            $table->string('nome', 100);
            $table->decimal('preco', 10, 2);
            $table->string('marca', 50)->nullable();
            $table->text('descricao')->nullable();
            $table->string('unidade', 20);
            $table->boolean('controla_estoque')->default(true);
            $table->integer('estoque_minimo')->default(0);
            $table->integer('estoque_maximo')->default(0);
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
