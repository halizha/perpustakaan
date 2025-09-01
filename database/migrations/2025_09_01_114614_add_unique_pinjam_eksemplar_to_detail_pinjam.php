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
        Schema::table('detail_pinjam', function (Blueprint $table) {
            // kasih unique supaya 1 eksemplar hanya bisa sekali dipinjam di pinjaman tertentu
            $table->unique(['pinjam_id', 'eksemplar_id'], 'unique_pinjam_eksemplar');
        });
    }

    public function down()
    {
        Schema::table('detail_pinjam', function (Blueprint $table) {
            $table->dropUnique('unique_pinjam_eksemplar');
        });
    }
};
