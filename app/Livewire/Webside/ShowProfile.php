<?php

namespace App\Livewire\Webside;

use App\Charts\AnimalWeightChart;

use App\Models\Animal;
use App\Models\AnimalWeight;
use Livewire\Component;

class ShowProfile extends Component
{
    public $animalToken, $animalId, $status;

    public function render()
    {
        $this->checkToken();
        $animal = (!empty($this->animalId)) ? Animal::find($this->animalId) : '';
        return view('livewire.webside.show-profile', [
            'animal' => $animal,
        ]);
    }

    public function checkToken()
    {
        if (!empty($this->animalToken)) {
            $animal = Animal::where('public_profile_tag', '=', $this->animalToken)->get();
            $this->status = $animal;
            if ($animal->count() > 0) {
                $this->animalId = $animal[0]->id;
            } else $this->status = "Nie znaleziono";
        }
    }
}
