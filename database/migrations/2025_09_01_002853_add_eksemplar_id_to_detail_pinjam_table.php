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
            $table->unsignedBigInteger('eksemplar_id')->nullable()->after('buku_id');
            $table->string('kode_eksemplar')->nullable()->after('eksemplar_id'); // optional snapshot
            $table->foreign('eksemplar_id')->references('id')->on('eksemplar_buku')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('detail_pinjam', function (Blueprint $table) {
            $table->dropForeign(['eksemplar_id']);
            $table->dropColumn(['eksemplar_id', 'kode_eksemplar']);
        });
    }
};
