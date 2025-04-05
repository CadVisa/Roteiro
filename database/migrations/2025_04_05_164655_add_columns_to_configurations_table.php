<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('versao_sistema')->nullable();
            $table->string('status_sistema')->nullable();
            $table->string('email_sistema')->nullable();
            $table->string('exibe_card')->nullable();
            $table->string('exibe_info_rodape')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn(
                'versao_sistema',
                'status_sistema',
                'email_sistema',
                'exibe_card', 
                'exibe_info_rodape');
        });
    }
};
