<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_cnae_id')->constrained('base_cnaes');
            $table->foreignId('user_id')->constrained('users');
            $table->string('tipo_movimento', 10);
            $table->dateTime('data_movimento');
            $table->string('descricao_movimento', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentos');
    }
};
