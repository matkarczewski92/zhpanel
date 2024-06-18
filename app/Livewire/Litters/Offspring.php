<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Offspring extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public $litterId;
    public $createAmount = 1;

    public function boot(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    #[On('render')]
    public function render()
    {
        return view('livewire.litters.offspring', [
            'animals' => $this->animalRepo->getByLitter($this->litterId),
            'animalRepo' => $this->animalRepo,
        ]);
    }

    public function addAnimals()
    {
        $litter = $this->litterRepo->getById($this->litterId);
        $parentMale = $this->animalRepo->getById($litter->parent_male);
        $date = Carbon::now();

        for ($i = 0; $i < $this->createAmount; ++$i) {
            $name = $litter->litter_code.' - Wąż nr '.$i + 1;
            $animal = new Animal();
            $animal->animal_category_id = '2';
            $animal->animal_type_id = $parentMale->animal_type_id;
            $animal->name = $name;
            $animal->sex = 1;
            $animal->date_of_birth = $date;
            $animal->litter_id = $litter->id;
            $animal->save();
            $profileTag = $animal->id.substr(uniqid(), -5);
            $profileTag = str_replace($animal->id, "", $profileTag);
            $profileTagUpdate = $this->animalRepo->getById($animal->id);
            $profileTagUpdate->public_profile_tag = $profileTag;
            $profileTagUpdate->save();

            $pt = $this->animalRepo->all();
            foreach($pt as $p)
            {
                $profileTag = $p->id.substr(uniqid(), -5);
                // $profileTag = str_replace($p->id, "", $profileTag);
                $profileTagUpdate = $this->animalRepo->getById($p->id);
                $profileTagUpdate->public_profile_tag = $profileTag;
                $profileTagUpdate->save();   
            }
        }

        return redirect(request()->header('Referer'));
    }
}
