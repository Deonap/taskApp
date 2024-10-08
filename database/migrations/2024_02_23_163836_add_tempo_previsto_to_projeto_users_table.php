<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('projeto_users', function (Blueprint $table) {
            $table->string('tempo_previsto')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('projeto_users', function (Blueprint $table) {
            $table->dropColumn('tempo_previsto');
        });
    }
};
