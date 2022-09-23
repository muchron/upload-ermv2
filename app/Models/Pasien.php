<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    public function regPeriksa()
    {
        return $this->hasMany(
            RegPeriksa::class,
            'no_rkm_medis',
            'no_rkm_medis'
        );
    }
}
