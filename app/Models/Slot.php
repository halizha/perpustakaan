<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'slot'; // nama tabel

    protected $primaryKey = 'id_slot'; // primary key

    protected $fillable = [
        'rak_id',   // foreign key ke tabel rak
        'kode_slot',
        'nama_slot',
    ];

    // Relasi Slot → Rak (many-to-one)
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id', 'id_rak');
    }
}
