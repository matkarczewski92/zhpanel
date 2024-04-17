<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\LittersPairing;
use Livewire\Component;

class PlannedOffspring extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public $litterId;
    public $percent;
    public $titleVis;
    public $titleHet;
    public $value;
    public $editMode = 0;
    public $editBtnMode = 'success';
    public $offspringEditMode = 0;
    public $ofspringEditPercent;
    public $ofspringEditHet;
    public $ofspringEditVis;
    public $ofspringEditValue;

    protected $rules = [
        'percent' => 'required',
        'titleVis' => 'required',
    ];
    protected $messages = [
        'percent.required' => 'Wprowadź udział procentowy',
        'titleVis.required' => 'Wprowadź nazwę genu',
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
        return view('livewire.litters.planned-offspring', [
            'offspring' => LittersPairing::where('litter_id', '=', $this->litterId)->get(),
            'litterRepo' => $this->litterRepo,
        ]);
    }

    public function create()
    {
        $this->validate();
        $pairing = new LittersPairing();
        $pairing->percent = $this->percent;
        $pairing->title_vis = $this->titleVis;
        $pairing->title_het = $this->titleHet;
        $pairing->litter_id = $this->litterId;
        $pairing->value = $this->value;
        $pairing->save();
        // $this->editModeSwitch();
        $this->reset('titleVis');
        $this->reset('titleHet');
        $this->reset('percent');
        $this->reset('value');
    }

    public function edit(int $id)
    {
        if ($this->offspringEditMode == 0 || $this->offspringEditMode != $id) {
            $off = LittersPairing::find($id);
            $this->offspringEditMode = $id;
            $this->ofspringEditPercent = $off->percent;
            $this->ofspringEditHet = $off->title_het;
            $this->ofspringEditVis = $off->title_vis;
            $this->ofspringEditValue = $off->value;
        } else {
            $this->offspringEditMode = 0;
        }
    }

    public function update()
    {
        $offspring = LittersPairing::find($this->offspringEditMode);
        $offspring->percent = $this->ofspringEditPercent;
        $offspring->title_vis = $this->ofspringEditVis;
        $offspring->title_het = $this->ofspringEditHet;
        $offspring->value = $this->ofspringEditValue;
        $offspring->save();
        $this->offspringEditMode = 0;
    }

    public function delete(int $id)
    {
        LittersPairing::where('id', $id)->delete();
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
