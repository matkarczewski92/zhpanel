<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;

class AvailableConnectionsController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    public function index()
    {
        return view('available-connections', [
            'females' => Animal::where('sex', 3)
            ->where(function ($query) {
                $query->where('animal_category_id', 1)
                ->orWhere('animal_category_id', 4);
            })
            ->get(),
            'males' => Animal::where('sex', 2)            
            ->where(function ($query) {
                $query->where('animal_category_id', 1)
                ->orWhere('animal_category_id', 4);
            })
            ->get(),
        ]);
    }

    public function show(string $id)
    {
        $litter = $this->litterRepo->getById($id);

        return view('litters.litters-profile', [
            'litter' => $litter,
            'category' => $this->litterRepo->litterCategory($litter->category),
            'animals' => Animal::where('litter_id', $id)->get(),
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
        ]);
    }
}
