<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot', function (Blueprint $table) {
            $table->id('id_slot');
            $table->unsignedBigInteger('id_rak'); // relasi ke rak
            $table->string('kode_slot');
            $table->string('nama_slot');
            $table->timestamps();

            $table->foreign('id_rak')->references('id_rak')->on('rak')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot');
    }
};
