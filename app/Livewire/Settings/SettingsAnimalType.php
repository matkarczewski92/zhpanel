<?php

namespace App\Livewire\Settings;

use App\Models\Animal;
use App\Models\AnimalType;
use Livewire\Component;

class SettingsAnimalType extends Component
{
    public $name = "";
    public $categoryId = "";
    public $status = '';
    public $editId = '';
    public $editIdNew = '';
    public $editName = '';

    public function render()
    {
        return view('livewire.settings.settings-animal-type', [
            'animalType' => AnimalType::all(),
        ]);
    }

    public function save()
    {
        AnimalType::create(['name' => $this->name]);
        session()->flash('settingsAnimalTypeMsg', 'Pozycja ' . $this->name . ' została dodana');
        session()->flash('settingsAnimalTypeMsgColor', 'success');
        $this->reset();
    }
    public function editShow(int $id)
    {
        $categoryEdit = AnimalType::find($id);
        $this->editName = $categoryEdit->name;
        $this->editId = $id;
        $this->editIdNew = $id;
    }
    public function editSave()
    {
        $categoryEdit = AnimalType::find($this->editId);
        $check = Animal::where('animal_type_id', '=', $categoryEdit->id)->count();
        if ($check == 0) {
            if ($this->editName != '') {
                $categoryEdit->name = $this->editName;
                $categoryEdit->id = $this->editIdNew;
                $categoryEdit->save();
                session()->flash('settingsAnimalTypeMsg', 'Pozycja ' . $this->editName . ' została edytowana');
                session()->flash('settingsAnimalTypeMsgColor', 'warning');
                $this->reset();
            } else {
                $categoryEdit->delete();
                session()->flash('settingsAnimalCategoryMsg', 'Pozycja ' . $this->editName . ' została usunięta');
                session()->flash('settingsAnimalCategoryMsgColor', 'danger');
                $this->reset();
            }
        } else {
            session()->flash('settingsAnimalTypeMsg', 'Pozycja ' . $this->name . ' nie została usunięta/zmieniona ponieważ istnieją przypisane do niej zwierzęta.');
            session()->flash('settingsAnimalTypeMsgColor', 'danger');
            $this->reset();
        }
    }
}
