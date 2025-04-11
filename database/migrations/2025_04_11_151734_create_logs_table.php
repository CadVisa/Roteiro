<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('log_data');
            $table->ipAddress('log_ip');
            $table->string('log_nivel', 50);
            $table->string('log_chave', 50);
            $table->text('log_descricao');
            $table->text('log_observacoes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
