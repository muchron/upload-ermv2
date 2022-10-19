<?php

namespace App\Models;

use App\Models\RegPeriksa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KamarInap extends Model
{
    use HasFactory;
    protected $table = 'kamar_inap';
    public function regPeriksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }
}
