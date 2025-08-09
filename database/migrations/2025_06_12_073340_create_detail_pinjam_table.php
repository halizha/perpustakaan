<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('detail_pinjam', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pinjam_id');
        $table->unsignedBigInteger('buku_id');
        $table->timestamps();

        // Foreign Key
        $table->foreign('pinjam_id')->references('id')->on('pinjams')->onDelete('cascade');
        $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pinjam');
    }
};
