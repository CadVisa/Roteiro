<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 50)->nullable();
            $table->string('nome', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefone', 14)->nullable();
            $table->text('descricao')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('status')->default('Pendente');
        });
    
    }

    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};
