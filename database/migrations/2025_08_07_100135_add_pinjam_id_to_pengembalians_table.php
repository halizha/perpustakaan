<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->unsignedBigInteger('pinjam_id')->after('id');

            $table->foreign('pinjam_id')->references('id')->on('pinjams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropForeign(['pinjam_id']);
            $table->dropColumn('pinjam_id');
        });
    }
};
