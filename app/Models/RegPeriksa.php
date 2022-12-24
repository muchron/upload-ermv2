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
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
    }
    public function penjab()
    {
        return $this->belongsTo(Penjab::class, 'kd_pj', 'kd_pj');
    }
    public function diagnosaPasien()
    {
        return $this->hasMany(DiagnosaPasien::class, 'no_rawat', 'no_rawat');
    }
    public function detailPemberianObat()
    {
        return $this->hasMany(DetailPemberianObat::class, 'no_rawat', 'no_rawat');
    }
    public function detailPemeriksaanLab()
    {
        return $this->hasMany(DetailPemeriksaanLab::class, 'no_rawat', 'no_rawat');
    }
}
