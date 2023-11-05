<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalCategory;
use App\Models\AnimalType;
use App\Models\Feed;
use App\Models\Litter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnimalController extends Controller
{

    public function index(): View
    {
        return view('animals', [
            'animal' => Animal::where('animal_category_id', '=', 1)->orderBy('id', 'desc')->get(),
            'types' => AnimalType::all(),
        ]);
    }
    public function create(): View
    {
        return view('animals.animals-create-form', [
            'animal' => Animal::get(),
            'types' => AnimalType::all(),
            'feedTypes' => Feed::all(),
            'litters' => Litter::where('category', 1)->orWhere('category', 4)->get(),
            'category' => AnimalCategory::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $newAnimal =  new Animal;

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
        $profileTag =  $newAnimal->id . substr(uniqid(), -5);
        $profileTagUpdate = Animal::find($newAnimal->id);
        $profileTagUpdate->public_profile_tag = $profileTag;
        $profileTagUpdate->save();

        return redirect()
            ->route('animals.index')
            ->with('animals-status', 'Dodano nowe zwierze -  <b>Nazwa: </b>' . $request->name)
            ->with('animals-status-color', 'success');
    }

    public function edit($animalId): View
    {
        return view('animals.animals-edit-form', [
            'profil' => Animal::find($animalId),
            'types' => AnimalType::all(),
            'feedTypes' => Feed::all(),
            'litters' => Litter::where('category', 1)->orWhere('category', 4)->get(),
            'category' => AnimalCategory::all(),
        ]);
    }


    public function update(Request $request): RedirectResponse
    {
        $newAnimal =  Animal::find($request->animalId);
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

        $deleteAnimal = Animal::find($animalId);

        if ($deleteAnimal->animal_category_id != 0) { // if animal is not on category "deleted" then
            $deleteAnimal->animal_category_id = 0;
            $deleteAnimal->save();
        } else $deleteAnimal->delete(); // if animal is in category "deleted" -> pernament removal from db

        return redirect()
            ->route('animals.index')
            ->with('animals-status', 'Usunięto zwierze')
            ->with('animals-status-color', 'danger');
    }
}
