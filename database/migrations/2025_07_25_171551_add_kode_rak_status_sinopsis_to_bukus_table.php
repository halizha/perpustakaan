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
        Schema::table('bukus', function (Blueprint $table) {
        $table->string('kode_rak')->nullable();
        $table->string('status')->default('Tersedia'); // default status
        $table->text('sinopsis')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
        $table->dropColumn(['kode_rak', 'status', 'sinopsis']);
    });
    }
};
