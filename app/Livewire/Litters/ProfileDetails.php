<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use App\Models\Litter;
use Livewire\Component;

class ProfileDetails extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public $litterId;
    public $category;
    public $litterCode;
    public $connectionDate;
    public $layingDate;
    public $hatchingDate;
    public $layingEggsTotal;
    public $layingEggsOk;
    public $hatchingEggs;
    public $parentMale;
    public $parentFemale;
    public $season;
    public $plannedConnectionDate;
    public $editMode = 0;
    public $editBtnMode = 'success';
    protected $rules = [
        'litterCode' => 'required',
    ];
    protected $messages = [
        'litterCode.required' => 'Wprowadź kod miotu',
    ];

    public function boot(
        LitterRepositoryInterface $litterRepo,
        AnimalRepositoryInterface $animalRepo
    ) {
        $this->litterRepo = $litterRepo;
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        $litter = $this->litterRepo->getById($this->litterId);
        $this->category = $litter->category;
        $this->litterCode = $litter->litter_code;
        $this->connectionDate = $litter->connection_date;
        $this->layingDate = $litter->laying_date;
        $this->hatchingDate = $litter->hatching_date;
        $this->layingEggsTotal = $litter->laying_eggs_total;
        $this->layingEggsOk = $litter->laying_eggs_ok;
        $this->hatchingEggs = $litter->hatching_eggs;
        $this->parentMale = $litter->parent_male;
        $this->parentFemale = $litter->parent_female;
        $this->season = $litter->season;
        $this->plannedConnectionDate = $litter->planned_connection_date;

        return view('livewire.litters.profile-details', [
            'litter' => $litter,
            'status' => $this->litterRepo->litterStatus($this->litterId),
            'category' => $this->litterRepo->litterCategory($litter->category),
            'animals' => Animal::where('litter_id', $litter->id)->get(),
            'animalsMale' => Animal::where('sex', 2)->where('animal_category_id', '!=', 2)->where('animal_category_id', '!=', 3)->where('animal_category_id', '!=', 5)->get(),
            'animalsFemale' => Animal::where('sex', 3)->where('animal_category_id', '!=', 2)->where('animal_category_id', '!=', 3)->where('animal_category_id', '!=', 5)->get(),
            'litterRepo' => $this->litterRepo,
            'litterValue' => $this->litterRepo->litterValue($this->litterId),
        ]);
    }

    public function save(): void
    {
        $this->validate();
        $litter = $this->litterRepo->getById($this->litterId);
        $litter->category = $this->category;
        $litter->litter_code = $this->litterCode;
        $litter->connection_date = (!empty($this->connectionDate)) ? $this->connectionDate : null;
        $litter->laying_date = (!empty($this->layingDate)) ? $this->layingDate : null;
        $litter->hatching_date = (!empty($this->hatchingDate)) ? $this->hatchingDate : null;
        $litter->laying_eggs_total = ($this->layingEggsTotal == '') ? 0 : $this->layingEggsTotal;
        $litter->laying_eggs_ok = ($this->layingEggsOk == '') ? 0 : $this->layingEggsOk;
        $litter->hatching_eggs = ($this->hatchingEggs == '') ? 0 : $this->hatchingEggs;
        $litter->parent_male = $this->parentMale;
        $litter->parent_female = $this->parentFemale;
        $litter->season = $this->season;
        $litter->planned_connection_date = (!empty($this->plannedConnectionDate)) ? $this->plannedConnectionDate : null;
        // dd($litter->planned_connection_date);
        $litter->save();
        $this->editModeSwitch();
    }

    public function delete()
    {
        Litter::find($this->litterId)->delete();

        return redirect(route('litters.index'));
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
