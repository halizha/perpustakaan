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
        Schema::table('pinjams', function (Blueprint $table) {
            $table->dateTime('tgl_pinjam')->change();
            $table->dateTime('tgl_kembali')->change();
        });
    }

    public function down()
    {
        Schema::table('pinjams', function (Blueprint $table) {
            $table->date('tgl_pinjam')->change();
            $table->date('tgl_kembali')->change();
        });
    }
};
