<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalCategoryRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\AnimalTypeRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnimalController extends Controller
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
        $this->animalTypeRepository = $animalTypeRepository;
        $this->animalCategoryRepository = $animalCategoryRepository;
        $this->feedRepository = $feedRepository;
        $this->litterRepository = $litterRepository;
    }

    public function index(): View
    {
        return view('animals', [
            'animal' => $this->animalRepo->getAllInBreeding(),
            'types' => $this->animalTypeRepository->all(),
            'repo' => $this->animalRepo,
        ]);
    }

    public function create(): View
    {
        return view('animals.animals-create-form', [
            'animal' => $this->animalRepo->all(),
            'types' => $this->animalTypeRepository->all(),
            'feedTypes' => $this->feedRepository->all(),
            'litters' => $this->litterRepository->getAvailable(),
            'category' => $this->animalCategoryRepository->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $newAnimal = new Animal();

        $newAnimal->name = $request->name;
        $newAnimal->sex = $request->sex;
        $newAnimal->date_of_birth = $request->date_of_birth;
        $newAnimal->litter_id = $request->litter_id;
        $newAnimal->feed_id = $request->feed_id;
        $newAnimal->feed_interval = $request->feed_interval;
        $newAnimal->feed_interval = $request->feed_interval;
        $newAnimal->animal_type_id = $request->animal_type_id;
        $newAnimal->animal_category_id = $request->animal_category_id;
        $newAnimal->save();
        $profileTag = $newAnimal->id.substr(uniqid(), -5);
        $profileTagUpdate = $this->animalRepo->getById($newAnimal->id);
        $profileTagUpdate->public_profile_tag = $profileTag;
        $profileTagUpdate->save();

        return redirect()
            ->route('animals.index')
            ->with('animals-status', 'Dodano nowe zwierze -  <b>Nazwa: </b>'.$request->name)
            ->with('animals-status-color', 'success');
    }

    public function edit($animalId): View
    {
        return view('animals.animals-edit-form', [
            'profil' => $this->animalRepo->getById($animalId),
            'types' => $this->animalTypeRepository->all(),
            'feedTypes' => $this->feedRepository->all(),
            'litters' => $this->litterRepository->getAvailable(),
            'category' => $this->animalCategoryRepository->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $newAnimal = $this->animalRepo->getById($request->animalId);
        $newAnimal->name = $request->name;
        $newAnimal->sex = $request->sex;
        $newAnimal->date_of_birth = $request->date_of_birth;
        $newAnimal->litter_id = $request->litter_id;
        $newAnimal->feed_id = $request->feed_id;
        $newAnimal->feed_interval = $request->feed_interval;
        $newAnimal->feed_interval = $request->feed_interval;
        $newAnimal->animal_type_id = $request->animal_type_id;
        $newAnimal->animal_category_id = $request->animal_category_id;
        $newAnimal->save();

        return redirect()
            ->route('animal.profile', $newAnimal->id)
            ->with('animals-status', 'Edytowano zwierze')
            ->with('animals-status-color', 'warning');
    }

    public function destroy(int $animalId): RedirectResponse
    {
        $deleteAnimal = $this->animalRepo->getById($animalId);

        if ($deleteAnimal->animal_category_id != 0) { // if animal is not on category "deleted" then
            $deleteAnimal->animal_category_id = 0;
            $deleteAnimal->save();
        } else {
            $deleteAnimal->delete();
        } // if animal is in category "deleted" -> pernament removal from db

        return redirect()
            ->route('animals.index')
            ->with('animals-status', 'Usunięto zwierze')
            ->with('animals-status-color', 'danger');
    }
}
