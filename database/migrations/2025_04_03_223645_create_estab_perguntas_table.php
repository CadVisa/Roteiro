<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estab_perguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estab_cnae_id')->constrained('estab_cnaes');
            $table->text('pergunta')->nullable();
            $table->string('competencia')->nullable();
            $table->string('grau_sim')->nullable();
            $table->string('grau_nao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estab_perguntas');
    }
};
