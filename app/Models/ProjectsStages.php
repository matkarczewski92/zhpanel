<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectsStages extends Model
{
    use HasFactory;
    protected $fillable = ['season', 'project_id', 'parent_male_id', 'parent_male_name', 'parent_female_id', 'parent_female_name'];

    public function getParentMaleDetails(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'parent_male_id');
    }

    public function getParentFemaleDetails(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'parent_female_id');
    }

    public function getStagesNfs(): HasMany
    {
        return $this->hasMany(ProjectsStagesNfs::class, 'stage_id', 'id');
    }
}
