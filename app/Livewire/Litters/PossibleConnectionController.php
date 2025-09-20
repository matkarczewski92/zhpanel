<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalGenotypeCategory;
use Livewire\Component;

class PossibleConnectionController extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;
    public $females = [];
    public $finale = [];
    public $selectedFemale = null;
    public $dictionary;

    public function boot(
        LitterRepositoryInterface $litterRepo,
        AnimalRepositoryInterface $animalRepo
    ) {
        $this->litterRepo = $litterRepo;
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        $this->dictionary = $this->getDictionary();
        $this->females = $this->animalRepo->getAllInBreedingFemales();
        

        return view('livewire.litters.possible-connection-controller');
    }

    public function updatedSelectedFemale($value): void
    {
        $this->createFinale($value);
    }

    public function createFinale($femaleId): void
    {
        if (!empty($femaleId)) {
            $possibleCombinations = [];
            $fm = $this->animalRepo->getById($femaleId);
            $female = $this->getAnimalArray($this->animalRepo->getById($femaleId));
            $males = $this->animalRepo->getAllInBreedingMales()->where('animal_type_id', $fm->animal_type_id);
            dd($males);
            foreach ($males as $male) {
            $maleObj = $this->getAnimalArray($male);
            $finalCombinations = getGenotypeFinale($maleObj, $female, $this->dictionary);
                $possibleCombinations[$male->name] = $finalCombinations;
            }
            $this->finale = $possibleCombinations;
        } else {
            $this->finale = null;
        }
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
