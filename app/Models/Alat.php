<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = ['kode_alat', 'nama_alat', 'kategori', 'status'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
