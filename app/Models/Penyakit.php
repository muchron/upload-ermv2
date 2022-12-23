<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;
    protected $table = "penyakit";

    public function diagnosaPasien()
    {
        return $this->hasOne(DiagnosaPasien::class, 'kd_penyakit', 'kd_penyakit');
    }
}
