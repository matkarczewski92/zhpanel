<?php

namespace App\Livewire\Animal;

use App\Http\Controllers\AnimalProfileController;
use App\Models\Animal;
use App\Models\Feed;
use Livewire\Component;
use Livewire\Attributes\On;

class AnimalProfileDetails extends Component
{
    public $animalId = "";
    public $feedId = "";
    public $sex = "";

    #[On('animal-profile-details')]
    public function render()
    {
        return view('livewire.animal.animal-profile-details', [
            'animal' => Animal::find($this->animalId),
            'feedInterval' => feedInterval($this->animalId),
            'lastFeeding' => lastFeed($this->animalId),
            'nextFeed' => nextFeed($this->animalId),
            'feed' => Feed::find($this->feedId),
            'sexName' => sexName($this->sex),
        ]);
    }
}
