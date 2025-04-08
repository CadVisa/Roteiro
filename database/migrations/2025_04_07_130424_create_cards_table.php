<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_icone', 30)->nullable();
            $table->string('card_titulo', 100)->nullable();
            $table->text('card_descricao')->nullable();
            $table->integer('card_ordem')->nullable();
            $table->string('card_status', 8)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
