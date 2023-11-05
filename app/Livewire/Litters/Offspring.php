<?php

namespace App\Livewire\Litters;

use App\Models\Animal;
use App\Models\Litter;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Offspring extends Component
{
    public $litterId, $createAmount = 1;

    #[On('render')]
    public function render()
    {
        return view('livewire.litters.offspring', [
            'animals' => Animal::where('litter_id', $this->litterId)->get(),
        ]);
    }

    public function addAnimals()
    {
        $litter = Litter::find($this->litterId);
        $parentMale = Animal::find($litter->parent_male);
        $date = Carbon::now();

        for ($i = 0; $i < $this->createAmount; $i++) {
            $name = $litter->litter_code . ' - Wąż nr ' . $i + 1;
            $animal = new Animal;
            $animal->animal_category_id = '2';
            $animal->animal_type_id = $parentMale->animal_type_id;
            $animal->name = $name;
            $animal->sex = 1;
            $animal->date_of_birth = $date;
            $animal->litter_id = $litter->id;
            $animal->save();
        }
        return redirect(request()->header('Referer'));
    }
}
