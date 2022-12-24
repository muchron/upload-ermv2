<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateLaboratorium extends Model
{
    use HasFactory;
    protected $table = 'template_laboratorium';
    public function detailPemeriksaanLab()
    {
        return $this->hasMany(DetailPemeriksaanLab::class, 'id_template', 'id_template');
    }
}
