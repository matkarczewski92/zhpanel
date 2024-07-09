<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalCategoryRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\AnimalTypeRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalPassport extends Controller
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
        FeedRepositoryInterface $feedRepository,
        LitterRepositoryInterface $litterRepository
    ) {
        $this->animalRepo = $animalRepo;
        $this->feedRepository = $feedRepository;
    }

    public function index(Animal $id)
    {
        return view('animals.profile.animal-profile-passport',[
            'animal' => $this->animalRepo->getById($id->id),
            'feed' => $this->feedRepository->getById($id->feed_id),
            'sexName' => $this->animalRepo->sexName($id->sex),
        ]);
    }
}
