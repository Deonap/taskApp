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
        Schema::create('projeto_users', function (Blueprint $table) {
            $table->foreignId('projeto_id')->constrained('projetos');
            $table->foreignId('user_id')->constrained('users');
            $table->string('tempo_gasto')->default('00:00');
            $table->text('observacoes')->nullable();
            
            $table->timestamps();

            $table->primary(['projeto_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto_users');
    }
};
