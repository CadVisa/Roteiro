<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consents', function (Blueprint $table) {
            $table->unsignedBigInteger('documento_legal_id')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consents', function (Blueprint $table) {
            $table->dropColumn('documento_legal_id');
        });
    }
};
