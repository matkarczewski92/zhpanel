<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use Illuminate\Contracts\View\View;

class ForSaleController extends Controller
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
            'animal' => Animal::where('animal_category_id', '=', 2)->get(),
            'title' => 'Maluchy',
            'animalRepo' => $this->animalRepo,
        ]);
    }
}
