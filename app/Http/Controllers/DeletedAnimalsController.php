<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DeletedAnimalsController extends Controller
{
    public function index(): View
    {
        return view('for-sale', [
            'animal' => Animal::where('animal_category_id', '=', 0)->get(),
            'title' => "Sprzedane"
        ]);
    }
}
