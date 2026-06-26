<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    protected $fillable = ['nama', 'nim_nip', 'kontak'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
