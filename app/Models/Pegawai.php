<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $guarded = [];

    public function alat()
    {
        return $this->belongsToMany(Alat::class);
    }
}