<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanPakai extends Model
{
    use HasFactory;
    protected $table = 'aturan_pakai';
    public function detailPemberianObat()
    {
        return $this->hasMany(DetailPemberianObat::class, ['no_rawat', 'kd_barang'], ['no_rawat', 'kd_barang']);
    }
}
