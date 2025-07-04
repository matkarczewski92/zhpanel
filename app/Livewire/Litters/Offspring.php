<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\AnimalWeight;


class Offspring extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public $litterId;
    public $createAmount = 1;
    public $editBtnMode = 'success';
    public $editMode = 0;
    public $editSex;
    public $editName;
    public $inputDate;
    public array $editAnimals = [];

    public function boot(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }
    public function mount($litterId)
    {
        $this->litterId = $litterId;

        $this->editAnimals = $this->animalRepo->getByLitter($litterId)
            ->mapWithKeys(fn($a) => [
                $a->id => ['name' => $a->name, 'sex' => $a->sex, 'weight' => $this->animalRepo->lastWeight($a->id)]
            ])
            ->toArray();
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
            $profileTag = substr($profileTag, 2);
            $profileTagUpdate = $this->animalRepo->getById($animal->id);
            $profileTagUpdate->public_profile_tag = $profileTag;
            $profileTagUpdate->save();
        }

        return redirect(request()->header('Referer'));
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



    public function saveEdit()
    {
        foreach ($this->editAnimals as $id => $eA) {
            // Aktualizacja podstawowych danych
            $animal = Animal::findOrFail($id);

            if (isset($eA['name'])) {
                $animal->name = $eA['name'];
            }

            if (isset($eA['sex'])) {
                $animal->sex = (int) $eA['sex'];
            }

            $animal->save();

            // Zapisz wagę tylko jeśli uzupełniona i inna niż ostatnia
            if (isset($eA['weight']) && $eA['weight'] !== '') {
                $newWeight = (float) $eA['weight'];
                $lastWeight = (float) $this->animalRepo->lastWeight($id);

                if ($newWeight !== $lastWeight) {
                    $date = Carbon::now()->format('Y-m-d');

                    $weight = new AnimalWeight();
                    $weight->animal_id = $id;
                    $weight->created_at = $date;
                    $weight->value = $newWeight;
                    $weight->save();
                }
            }
        }

        $this->mount($this->litterId);
        $this->editModeSwitch();
        session()->flash('message', 'Zapisano zmiany.');
    }



}
