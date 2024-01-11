<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\AnimalWinteringRepositoryInterface;
use App\Models\Wintering;
use Illuminate\Contracts\View\View;

class WinteringController extends Controller
{
    private AnimalWinteringRepositoryInterface $winterignRepo;
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(
        AnimalWinteringRepositoryInterface $winterignRepo,
        AnimalRepositoryInterface $animalRepo,
    ) {
        $this->winterignRepo = $winterignRepo;
        $this->animalRepo = $animalRepo;
    }

    public function index(): View
    {
        return view('winterings', [
            'winterings' => $this->getAnimals(),
            'winteringRepo' => $this->winterignRepo,
            'animalRepo' => $this->animalRepo,
        ]);
    }

    public function getAnimals()
    {
        $animals = $this->animalRepo->all();
        foreach ($animals as $animal) {
            $count = Wintering::where('animal_id', $animal->id)->where('archive', null)->count();
            if ($count != 0) {
                $return[] = $animal;
            }
        }

        return $return ?? [];
    }
}
