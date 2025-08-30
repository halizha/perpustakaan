<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rak', function (Blueprint $table) {
            $table->id('id_rak');
            $table->string('kode_rak')->unique();
            $table->string('nama_rak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rak');
    }
};
