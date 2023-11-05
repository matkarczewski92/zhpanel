<?php

namespace App\Livewire\Animal;

use App\Models\AnimalMolt;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AnimalMoltsProfile extends Component
{
    public $animalId = "";
    public $date = "";
    protected $paginationTheme = 'bootstrap';
    public $editMode = 0;
    public $editBtnMode = "success";
    use WithPagination;


    public function render()
    {
        $this->date = Carbon::now()->format("Y-m-d");
        return view('livewire.animal.animal-molts-profile', [
            'molts' => AnimalMolt::where('animal_id', '=', $this->animalId)->orderBy('created_at', 'desc')->paginate(5),
        ]);
    }

    public function addMolt()
    {
        $molt = new AnimalMolt();
        $molt->animal_id = $this->animalId;
        $molt->created_at = $this->date;
        $molt->save();
        session()->flash('animalMolt', 'Pozycja została dodana');
        session()->flash('animalMoltColor', 'success');
    }

    public function delete(int $moltId)
    {
        $molt = AnimalMolt::find($moltId);
        if (!empty($molt->id)) $molt->delete();
        session()->flash('animalMolt', 'Pozycja została usunięta');
        session()->flash('animalMoltColor', 'danger');
    }

    public function editModeSwitch()
    {
        if ($this->editMode == 0) {
            $this->editMode = 1;
            $this->editBtnMode = "danger";
        } else {
            $this->editMode = 0;
            $this->editBtnMode = "success";
        }
    }
}
