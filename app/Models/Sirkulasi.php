<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sirkulasi extends Model
{
    use HasFactory;
    protected $table = 'pegawai_sirkulasi';
    protected $guarded = [];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class);
    }
}