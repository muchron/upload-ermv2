<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    use HasFactory;
    protected $table = 'reg_periksa';

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
    public function upload()
    {
        return $this->hasOne(Upload::class, 'no_rawat', 'no_rawat');
    }
}
