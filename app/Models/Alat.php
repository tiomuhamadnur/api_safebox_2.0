<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alat';
    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class);
    }
}