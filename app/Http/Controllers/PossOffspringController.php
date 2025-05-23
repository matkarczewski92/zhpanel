<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalGenotypeCategory;
use App\Models\AnimalGenotypeTraits;
use App\Models\Litter;
use Illuminate\Http\Request;

class PossOffspringController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    public function index()
    {
        $dictionary = $this->getDictionary();
        $this->getGenotypeTraitsDictionary();

        return view('possoffspring',[
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
            'litters' => $this->createArray(date("Y")),
            'dictionary' => $dictionary,
        ]);
    }

    public function createArray($season){
        $litters = Litter::where('season', $season)->get();
        $dictionary = $this->getDictionary();
        foreach($litters as $lt){
            $male = $this->getAnimalArray($this->litterRepo->getById($lt->id)->animalMale);
            $female = $this->getAnimalArray($this->litterRepo->getById($lt->id)->animalFemale); 
            $genotypeArray = getGenotypeFinale($male, $female, $dictionary);
            foreach($genotypeArray as $gA){
                if (strpos($gA['additional_genes'], "1/2 Tessera") !== false) {        
                    $gA['additional_genes'] = str_replace("1/2 Tessera", "", $gA['additional_genes']);
                    $gA['percentage'] = $gA['percentage']/2;
                    $finale[$lt->id][] = $gA;

                    $gA['dominant'] .= ", Tessera";
                    $finale[$lt->id][] = $gA;

                } else {
                    $finale[$lt->id][] = $gA;
                }
                
            }
            
        }
        return $finale;

    }

    public function getDictionary(){
        $gens = AnimalGenotypeCategory::all();
        $array=[];
        foreach($gens as $gen){
            $array[] = [$gen->gene_code, $gen->name];
        }
        return $array;
    }

    public function getGenotypeTraitsDictionary()
    {
        $traits = AnimalGenotypeTraits::orderBy('number_of_traits')->get();

        foreach($traits as $trait){
            foreach($trait->getTraitsDictionary as $tr){
                $array[$trait->number_of_traits][$trait->name][] = $tr->genotypeCategory->name;
            }
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
 