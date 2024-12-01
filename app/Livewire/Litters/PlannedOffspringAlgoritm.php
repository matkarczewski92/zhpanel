<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalGenotypeCategory;
use Livewire\Component;

class PlannedOffspringAlgoritm extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public $litterId;

    public function boot(
        LitterRepositoryInterface $litterRepo,
        AnimalRepositoryInterface $animalRepo
    ) {
        $this->litterRepo = $litterRepo;
        $this->animalRepo = $animalRepo;
    }


    public function render()
    {
        $dictionary = $this->getDictionary();
        $male = $this->getAnimalArray($this->litterRepo->getById($this->litterId)->animalMale);
        $female = $this->getAnimalArray($this->litterRepo->getById($this->litterId)->animalFemale);


        return view('livewire.litters.planned-offspring-algoritm',[
            'finale' => getGenotypeFinale($male, $female, $dictionary),
            'male' => $male,
            'female' => $female,
            'dictionary' => $dictionary,
            // 'id' => $this->litterId,

        ]);
    }
    public function getDictionary(){
        $gens = AnimalGenotypeCategory::all();
        $array=[];
        foreach($gens as $gen){
            $array[] = [$gen->gene_code, $gen->name];
        }
        return $array;
    }

    public function getAnimalArray($male){
        $genotype = $male->animalGenotype;
        $array = [];
        foreach($genotype as $gen)
        {
            if($gen->type=='h'){
                $array[] = [ucfirst($gen->genotypeCategory->gene_code),lcfirst($gen->genotypeCategory->gene_code)];
            } else if($gen->type=='v'){
                if($gen->genotypeCategory->gene_type=="r"){
                    $array[] = [lcfirst($gen->genotypeCategory->gene_code),lcfirst($gen->genotypeCategory->gene_code)];
                } else $array[] = [ucfirst($gen->genotypeCategory->gene_code),ucfirst($gen->genotypeCategory->gene_code)];

            }
        }
        return $array;
    }


}

