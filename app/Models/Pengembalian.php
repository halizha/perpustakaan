<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengembalians';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'pinjam_id', 'detail_pinjam_id', 'tgl_kembali', 'denda'];

    public function detail(): BelongsTo
    {
        return $this->belongsTo(DetailPinjam::class, 'detail_pinjam_id');
    }
    public function pinjam(): BelongsTo
    {
        return $this->belongsTo(Pinjam::class, 'pinjam_id');
    }
}
