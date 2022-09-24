<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function upload()
    {
        return $this->hasMany(Upload::class, 'no_rkm_medis', 'no_rkm_medis');
    }
}
