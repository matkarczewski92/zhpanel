<?php

namespace App\Livewire\Settings;

use App\Models\AnimalGenotype;
use App\Models\AnimalGenotypeCategory;
use Livewire\Component;

class SettingsAnimalGenotype extends Component
{
    public $name = "";
    public $categoryId = "";
    public $status = '';
    public $editId = '';
    public $editIdNew = '';
    public $editName = '';

    public function render()
    {
        return view('livewire.settings.settings-animal-genotype', [
            'animalGenotype' => AnimalGenotypeCategory::all(),
        ]);
    }

    public function save()
    {
        AnimalGenotypeCategory::create(['name' => $this->name]);
        session()->flash('settingsAnimalGenotypeMsg', 'Pozycja ' . $this->name . ' została dodana');
        session()->flash('settingsAnimalGenotypeMsgColor', 'success');
        $this->reset();
    }
    public function editShow(int $id)
    {
        $categoryEdit = AnimalGenotypeCategory::find($id);
        $this->editName = $categoryEdit->name;
        $this->editId = $id;
        $this->editIdNew = $id;
    }
    public function editSave()
    {
        $categoryEdit = AnimalGenotypeCategory::find($this->editId);
        if ($this->editName != '') {
            $categoryEdit->name = $this->editName;
            $categoryEdit->id = $this->editIdNew;
            $categoryEdit->save();
            session()->flash('settingsAnimalGenotypeMsg', 'Pozycja ' . $this->editName . ' została edytowana');
            session()->flash('settingsAnimalGenotypeMsgColor', 'warning');
            $this->reset();
        } else {
            $categoryEdit->delete();
            session()->flash('settingsAnimalGenotypeMsg', 'Pozycja ' . $this->editName . ' została usunięta');
            session()->flash('settingsAnimalGenotypeMsgColor', 'danger');
            $this->reset();
        }
    }
}
