<?php

namespace App\Livewire\Webside;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use Livewire\Component;

class ShowProfile extends Component
{
    public $animalToken;
    public $animalId;
    public $status;

    private AnimalRepositoryInterface $animalRepo;

    public function boot(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        $this->checkToken();
        $animal = (!empty($this->animalId)) ? Animal::find($this->animalId) : '';

        return view('livewire.webside.show-profile', [
            'animal' => $animal,
            'animalRepo' => $this->animalRepo,
        ]);
    }

    public function checkToken()
    {
        if (!empty($this->animalToken)) {
            $animal = Animal::where('public_profile_tag', '=', $this->animalToken)->get();
            $this->status = $animal;
            if ($animal->count() > 0) {
                $this->animalId = $animal[0]->id;
            } else {
                $this->status = 'Nie znaleziono';
            }
        }
    }
}
