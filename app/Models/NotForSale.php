<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NotForSale extends Model
{
    use HasFactory;

    public function pairingDetails(): HasOne
    {
        return $this->hasOne(LittersPairing::class, 'id', 'pairing_id');
    }
}
