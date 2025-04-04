<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('usa_api')->default('Não')->comment('Indica se a API da Receita Federal está habilitada ou não');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
