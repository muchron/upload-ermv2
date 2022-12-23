<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeSatuan extends Model
{
    use HasFactory;
    protected $table = 'kodesatuan';

    public function dataBarang()
    {
        return $this->hasMany(DataBarang::class, 'kodesat', 'kodesat');
    }
}
