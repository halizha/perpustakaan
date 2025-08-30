<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bukus';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'kategori_id', 'judul', 'penulis', 'penerbit', 'isbn', 'tahun', 'jumlah', 'sampul', 'kode_rak', 'sinopsis', 'status', 'slot_id'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailPinjam::class); // tetap pakai nama detail
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id', 'id_slot');
    }
}
