<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estab_cnaes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estabelecimento_id')->constrained('estabelecimentos');
            $table->string('codigo_cnae')->nullable();
            $table->string('codigo_limpo')->nullable();
            $table->text('descricao_cnae')->nullable();
            $table->string('grau_cnae')->nullable();
            $table->string('competencia')->nullable();
            $table->longText('notas_s_compreende')->nullable();
            $table->longText('notas_n_compreende')->nullable();            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estab_cnaes');
    }
};
