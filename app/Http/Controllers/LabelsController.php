<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalCategoryRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\AnimalTypeRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use Illuminate\Http\Request;

class LabelsController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private AnimalTypeRepositoryInterface $animalTypeRepository;
    private AnimalCategoryRepositoryInterface $animalCategoryRepository;
    private FeedRepositoryInterface $feedRepository;
    private LitterRepositoryInterface $litterRepository;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        AnimalTypeRepositoryInterface $animalTypeRepository,
        AnimalCategoryRepositoryInterface $animalCategoryRepository,
        LitterRepositoryInterface $litterRepository
    ) {
        $this->animalRepo = $animalRepo;
        $this->animalTypeRepository = $animalTypeRepository;
        $this->animalCategoryRepository = $animalCategoryRepository;
        $this->litterRepository = $litterRepository;
    }

    public function index(){
        return view('labels', [
            'animals' => $this->animalRepo->getAllUnsoldAnimals(),
            
        ]);
    }

    public function generate()
    {
        $animalLabel= [];
        foreach($_POST['animal'] as $animal => $value)
            {
                $animalLabel[$animal]['type'] = $this->animalRepo->getById(($animal))->animalType->name;
                $animalLabel[$animal]['id'] = $this->animalRepo->getById(($animal))->id;
                $animalLabel[$animal]['name'] = $this->animalRepo->getById(($animal))->name;
                $animalLabel[$animal]['sex'] = $this->animalRepo->getById(($animal))->sex;
                $animalLabel[$animal]['date_of_birth'] = $this->animalRepo->getById(($animal))->date_of_birth;
                $animalLabel[$animal]['code'] = $this->animalRepo->getById(($animal))->public_profile_tag;
            }

        return view('labels.labels-generate',[
            'animals' => $animalLabel ?? [],
            'repo' => $this->animalRepo,
        ]);

    }
}

