<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;
    protected $table = 'databarang';

    public function detailPemberianObat()
    {
        return $this->belongsTo(DetailPemberianObat::class, 'kode_brng', 'kode_brng');
    }
    public function kodeSatuan()
    {
        return $this->belongsTo(KodeSatuan::class, 'kode_sat', 'kode_sat');
    }
}
