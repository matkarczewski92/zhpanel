<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use Illuminate\Contracts\View\View;

class SoldController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
    ) {
        $this->animalRepo = $animalRepo;
    }

    public function index(): View
    {
        return view('for-sale', [
            'animal' => Animal::where('animal_category_id', '=', 3)->get(),
            'title' => 'Sprzedane',
            'animalRepo' => $this->animalRepo,
        ]);
    }
}
