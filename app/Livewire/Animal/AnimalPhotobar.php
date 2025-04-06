<?php

namespace App\Livewire\Animal;

use Livewire\Component;

class AnimalPhotobar extends Component
{
    public $animal;
    public $animalBannerPossition;

    public function render()
    {
        $this->animalBannerPossition = $this->animal->animalMainPhoto->banner_possition;

        return view('livewire.animal.animal-photobar', [
            'animal' => $this->animal
        ]);
    }

    public function bannerUp(){
        $photo = $this->animal->animalMainPhoto;

        if ($photo && $photo->banner_possition<100) {
            $photo->banner_possition++;
            $photo->save();
        }
        $this->dispatch('$refresh');
    }
    public function bannerDown(){
        $photo = $this->animal->animalMainPhoto;

        if ($photo && $photo->banner_possition>0) {
            $photo->banner_possition--;
            $photo->save();
        }
        $this->dispatch('$refresh');
    }
}
