<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPinjam extends Model
{
    use HasFactory;
    protected $table = 'detail_pinjam';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'pinjam_id', 'buku_id', 'eksemplar_id', 'kode_eksemplar', 'tgl_kembali',];

    public function pinjam()
    {
        return $this->belongsTo(Pinjam::class, 'pinjam_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'detail_pinjam_id');
    }

    public function eksemplar()
    {
        return $this->belongsTo(EksemplarBuku::class, 'eksemplar_id');
    }
}
