<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemberianObat extends Model
{
    use HasFactory;
    protected $table = 'detail_pemberian_obat';
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
    public function dataBarang()
    {
        return $this->hasOne(DataBarang::class, 'kode_brng', 'kode_brng');
    }
    public function aturanPakai()
    {
        return $this->belongsTo(AturanPakai::class, 'kode_brng',  'kode_brng');
    }
}
