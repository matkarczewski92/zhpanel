<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Wintering extends Model
{
    use HasFactory;

    public function stageDetails(): HasOne
    {
        return $this->hasOne(WinteringStages::class, 'id', 'stage_id');
    }
}
