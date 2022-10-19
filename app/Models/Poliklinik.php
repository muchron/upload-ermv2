<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    use HasFactory;
    protected $table = 'poliklinik';

    public function mappingPoli()
    {
        return $this->hasMany(MappingPoliklinik::class, 'kd_poli', 'kd_poli');
    }
}
