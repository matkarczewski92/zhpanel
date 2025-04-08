<?php

namespace App\Livewire\Settings;

use App\Models\AnimalGenotypeCategory;
use App\Models\AnimalGenotypeTraits;
use App\Models\AnimalGenotypeTraitsDictionary;
use Livewire\Component;

class SettingsGenotypeTraitsDictionary extends Component
{
    public $name = "";
    public $searchEng = "";
    public $gensId = [];
    public $traitName = "";


    public function render()
    {

        return view('livewire.settings.settings-genotype-traits-dictionary',[
            'traits' => AnimalGenotypeTraits::orderBy('id')->get(),
            'gens' => AnimalGenotypeCategory::all(),
        ]);
    }

    public function addToTraits($traitId)
    {
        $genId = $this->gensId[$traitId];
        $trait = AnimalGenotypeTraits::findOrFail($traitId);
        $trait->number_of_traits++;
        $trait->save();
        $newTrait = new AnimalGenotypeTraitsDictionary();
        $newTrait->trait_id = $traitId;
        $newTrait->category_id = $genId;
        $newTrait->save();

    }
    public function deleteTraitFromDictionary($traitId)
    {
        // dd($traitId);
        $trait = AnimalGenotypeTraits::findOrFail($traitId['trait_id']);
        $trait->number_of_traits--;
        $trait->save();
        $trait = AnimalGenotypeTraitsDictionary::findOrFail($traitId['id'])->delete();
    }

    public function addTrait()
    {
        $trait = new AnimalGenotypeTraits();
        $trait->name = $this->traitName;
        $trait->save();
    }


}
