<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak'; // pastikan sesuai nama tabel

    protected $primaryKey = 'id_rak'; // kalau pakai id_rak

    protected $fillable = [
        'kode_rak',
        'nama_rak'
    ];

    public function slots()
{
    return $this->hasMany(Slot::class, 'rak_id', 'id_rak');
}

}
