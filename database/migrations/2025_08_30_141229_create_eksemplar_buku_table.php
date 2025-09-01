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
        Schema::create('eksemplar_buku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_id');
            $table->string('kode_eksemplar')->unique();
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Hilang', 'Rusak'])->default('Tersedia');
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eksemplar_buku');
    }
};
