<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemeriksaanLab extends Model
{
    use HasFactory;
    protected $table = 'detail_periksa_lab';
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    public function jnsPerawatanLab()
    {
        return $this->belongsTo(JnsPerawatanLab::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }
    public function template()
    {
        return $this->belongsTo(TemplateLaboratorium::class, 'id_template', 'id_template');
    }
}
