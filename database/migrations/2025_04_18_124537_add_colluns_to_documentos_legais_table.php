<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentos_legais', function (Blueprint $table) {
            $table->string('versao')->nullable()->after('politica_privacidade');
        });
    }

    public function down(): void
    {
        Schema::table('documentos_legais', function (Blueprint $table) {
            $table->dropColumn('versao');
        });
    }
};
