<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use Illuminate\Contracts\View\View;

class DeletedAnimalsController extends Controller
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
            'animal' => Animal::where('animal_category_id', '=', 0)->get(),
            'title' => 'Sprzedane',
            'animalRepo' => $this->animalRepo,
        ]);
    }
}
