<?php

namespace App\Livewire\Settings;

use App\Models\AnimalCategory;
use Livewire\Component;

class SettingsAnimalCategory extends Component
{
    public $name = "";
    public $categoryId = "";
    public $status = '';
    public $editId = '';
    public $editName = '';

    public function render()
    {
        return view('livewire.settings.settings-animal-category', [
            'animalCategory' => AnimalCategory::all(),
        ]);
    }

    public function save()
    {
        AnimalCategory::create(['name' => $this->name]);
        session()->flash('settingsAnimalCategoryMsg', 'Pozycja ' . $this->name . ' została dodana');
        session()->flash('settingsAnimalCategoryMsgColor', 'success');
        $this->reset();
    }
    public function editShow(int $id)
    {
        $categoryEdit = AnimalCategory::find($id);
        $this->editName = $categoryEdit->name;
        $this->editId = $id;
    }
    public function editSave()
    {
        $categoryEdit = AnimalCategory::find($this->editId);
        $categoryEdit->name = $this->editName;
        $categoryEdit->save();
        session()->flash('settingsAnimalCategoryMsg', 'Pozycja ' . $this->editName . ' została edytowana');
        session()->flash('settingsAnimalCategoryMsgColor', 'warning');
        $this->reset();
    }
}
