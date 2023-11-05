<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Finances extends Model
{
    use HasFactory;

    public function financesCategory(): HasOne
    {
        return $this->hasOne(FinancesCategory::class, 'id', 'finances_category_id');
    }

    public function animalDetails(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'id');
    }
    public function feedDetails(): BelongsTo
    {
        return $this->belongsTo(Feed::class, 'feed_id', 'id');
    }
}
