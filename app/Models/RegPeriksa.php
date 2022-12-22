<?php

namespace App\Models;

use App\Models\Pasien;
use App\Models\Upload;
use App\Models\KamarInap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->hasMany(Upload::class, 'no_rawat', 'no_rawat');
    }
    public function kamarInap()
    {
        return $this->hasOne(KamarInap::class, 'no_rawat', 'no_rawat');
    }
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }
    public function pemeriksaanRalan()
    {
        return $this->hasMany(PemeriksaanRalan::class, 'no_rawat', 'no_rawat');
    }
}
