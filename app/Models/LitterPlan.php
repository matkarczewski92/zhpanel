<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitterPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'planned_year',
    ];

    public function pairs()
    {
        return $this->hasMany(LitterPlanPair::class);
    }
}
