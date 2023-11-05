<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LittersPairing extends Model
{
    use HasFactory;
    protected $table = 'litters_pairings';

    public function litterDetails(): HasOne
    {
        return $this->hasOne(Litter::class, 'id', 'litter_id');
    }
}
