<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DetailPinjam;

class Pinjam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pinjams';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'buku_id', 'user_id', 'tgl_pinjam', 'tgl_kembali', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(DetailPinjam::class, 'pinjam_id');
    }
}
