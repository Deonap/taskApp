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
        Schema::table('projeto_users', function (Blueprint $table) {
            $table->boolean('notificacaoVista')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projeto_users', function (Blueprint $table) {
            $table->dropColumn('notificacaoVista');
        });
    }
};
