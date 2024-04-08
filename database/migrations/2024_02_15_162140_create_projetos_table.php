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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('tipo_cliente_id')->constrained('tipo_clientes');
            $table->foreignId('estado_projeto_id')->constrained('estado_projetos');
            $table->string('tempo_previsto');
            $table->text('observacoes')->nullable();
            $table->string('tempo_gasto')->default('00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
