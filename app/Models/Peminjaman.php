<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = ['alat_id', 'peminjam_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }
}