<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancesCategory extends Model
{
    use HasFactory;
    protected $table = 'finances_category';
    protected $fillable = ['name'];
}
