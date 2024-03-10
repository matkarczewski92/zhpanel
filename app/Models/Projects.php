<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Projects extends Model
{
    use HasFactory;

    public function annotations(): HasOne
    {
        return $this->hasOne(ProjectAnnotations::class, 'project_id', 'id');
    }
}
