<?php

namespace App\Livewire\Animal;

use App\Models\Wintering;
use Livewire\Component;

class AnimalWinteringProfile extends Component
{
    public $animalId = '';
    public $editMode = 0;
    public $editBtnMode = 'success';

    public function render()
    {
        return view('livewire.animal.animal-wintering-profile', [
            'winterings' => Wintering::where('animal_id', $this->animalId)->get(),
        ]);
    }

    public function editModeSwitch()
    {
        if ($this->editMode == 0) {
            $this->editMode = 1;
            $this->editBtnMode = 'danger';
        } else {
            $this->editMode = 0;
            $this->editBtnMode = 'success';
        }
    }
}
