<?php

namespace App\Models;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LitterPlanPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'litter_plan_id',
        'female_id',
        'male_id',
    ];

    public function plan()
    {
        return $this->belongsTo(LitterPlan::class, 'litter_plan_id');
    }

    public function female()
    {
        return $this->belongsTo(Animal::class, 'female_id');
    }

    public function male()
    {
        return $this->belongsTo(Animal::class, 'male_id');
    }
}
