<?php

use App\Models\Pinjam;
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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_pinjam_id');
            $table->date('tgl_kembali')->nullable();
            $table->string('denda')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('detail_pinjam_id')->references('id')->on('detail_pinjam')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
