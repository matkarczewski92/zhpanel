<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ForSaleController extends Controller
{
    public function index(): View
    {
        return view('for-sale', [
            'animal' => Animal::where('animal_category_id', '=', 2)->get(),
            'title' => "Maluchy"
        ]);
    }
}
