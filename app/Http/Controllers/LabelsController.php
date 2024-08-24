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
}

