<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalFeedings extends Model
{
    use HasFactory;
    protected $table = 'animal_feedings';

    public function feedType(): HasOne
    {
        return $this->hasOne(Feed::class, 'id', 'feed_id');
    }
}
