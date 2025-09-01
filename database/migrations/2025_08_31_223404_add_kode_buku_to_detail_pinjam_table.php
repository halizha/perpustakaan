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
        $table->string('kode_buku')->nullable()->after('buku_id');
    });
}

public function down()
{
    Schema::table('detail_pinjam', function (Blueprint $table) {
        $table->dropColumn('kode_buku');
    });
}

};
