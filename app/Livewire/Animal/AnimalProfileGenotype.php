<?php

namespace App\Livewire\Animal;

use App\Models\Animal;
use App\Models\AnimalCategory;
use App\Models\AnimalGenotype;
use App\Models\AnimalGenotypeCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class AnimalProfileGenotype extends Component
{
    public $animalId = "";
    public $name = "";
    public $searchEng = "";
    public $data = [];
    public $typeInput = [];
    public $editMode = 0;
    public $editBtnMode = "success";


    #[On('animal-genotype-render')]
    public function render()
    {

        return view('livewire.animal.animal-profile-genotype', [
            'animal' => Animal::find($this->animalId),
            'genotypeVis' => $this->animalGenotype('v', $this->animalId),
            'genotypeHet' => $this->animalGenotype('h', $this->animalId),
            'genotypePos' => $this->animalGenotype('p', $this->animalId),
            'search' => $this->searchSuggestions(),
        ]);
    }

    public function animalGenotype(String $type, int $animalId)
    {
        return AnimalGenotype::where('animal_id', '=', $animalId)->where('type', '=', $type)->get();
    }
    //int $genotypeId, $animalId, String $type
    public function addGenotypeToProfile()
    {
        $dataset = explode('.', $this->name);
        if ($this->typeInput != '' and $this->name != '' and is_numeric($dataset[0])) {
            $genotype = new AnimalGenotype;
            $genotype->animal_id = $this->animalId;
            $genotype->genotype_id = $dataset[0];
            $genotype->type = $this->typeInput;
            $genotype->save();
            $this->reset('name');
        }
    }
    public function searchSuggestions()
    {
        $data[] = ['name' => "", 'id' => ""];
        if ($this->name != '') {
            $this->searchEng = '1';
            $dataD = AnimalGenotypeCategory::where('name', 'LIKE', '%' . $this->name . '%')->get();
            foreach ($dataD as $d) {
                $data[] = [
                    'name' => $d->name,
                    'id' => $d->id,
                ];
            }
        }
        return $data;
    }
    public function delete(int $id)
    {
        AnimalGenotype::find($id)->delete();
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
