<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EksemplarBuku extends Model
{
    use HasFactory;

    protected $table = 'eksemplar_buku';
    protected $primaryKey = 'id';
    protected $fillable = [
        'buku_id',
        'kode_eksemplar',
        'status',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function detail()
{
    return $this->hasMany(DetailPinjam::class, 'eksemplar_id');
}


}
