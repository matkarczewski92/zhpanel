<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalGenotypeCategory;
use App\Models\Litter;
use Livewire\Component;

class PossibleConnectionController extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public $females = [];                 // kolekcja samic do selecta
    public $femalesMap = [];              // [id => name] do podsumowania
    public $malesMap = [];                // [id => name] cache nazw samców

    public $finale = [];                  // aktualny wynik dla wybranej samicy: [maleId => ['name'=>..., 'rows'=>[]]]
    public $finaleCache = [];             // cache wyników: [femaleId][maleId] = ['name'=>..., 'rows'=>[]]

    public $selectedFemale = null;        // id samicy z selecta
    public $selectedPairs = [];           // wybrane pary: ['femaleId:maleId' => ['female_id'=>..,'male_id'=>..]]
    public $showSummary = false;          // drugi modal
    public $pairedFemaleIds = [];         // <- IDs samic już sparowanych
    public $showAddLitters = false;     // modal „Dodaj mioty”
    public $plannedYear = null;         // rok planu

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
        $this->females    = $this->animalRepo->getAllInBreedingFemales();
        $this->femalesMap = $this->females->pluck('name','id')->toArray();

        // << NOWE >> wylicz listę samic, które mają już wybraną parę
        $this->pairedFemaleIds = array_values(array_unique(
            array_map(fn($p) => (int)$p['female_id'], $this->selectedPairs)
        ));

        return view('livewire.litters.possible-connection-controller');
    }

    public function updatedSelectedFemale($value): void
    {
        $this->createFinale($value);
    }

    public function createFinale($femaleId): void
    {
        if (empty($femaleId)) {
            $this->finale = [];
            return;
        }

        // jeśli mamy cache, użyj
        if (isset($this->finaleCache[$femaleId])) {
            $this->finale = $this->finaleCache[$femaleId];
            return;
        }

        $possibleCombinations = [];

        $fm     = $this->animalRepo->getById($femaleId);
        $female = $this->getAnimalArray($fm);
        $males  = $this->animalRepo
            ->getAllInBreedingMales()
            ->where('animal_type_id', $fm->animal_type_id);

        foreach ($males as $male) {
            $maleObj           = $this->getAnimalArray($male);
            $finalCombinations = getGenotypeFinale($maleObj, $female, $this->dictionary);

            // zapamiętaj nazwę samca
            $this->malesMap[$male->id] = $male->name;

            // kluczem jest ID samca (żeby checkbox mógł działać stabilnie)
            $possibleCombinations[$male->id] = [
                'name' => $male->name,
                'rows' => $finalCombinations,
            ];
        }

        $this->finale = $possibleCombinations;
        $this->finaleCache[$femaleId] = $possibleCombinations;
    }

    public function getDictionary()
    {
        $gens = AnimalGenotypeCategory::all();
        $array = [];
        foreach ($gens as $gen) {
            $array[] = [$gen->gene_code, $gen->name];
        }
        return $array;
    }

    public function getAnimalArray($animal)
    {
        $genotype = $animal->animalGenotype;
        $array = [];
        foreach ($genotype as $gen) {
            if ($gen->type == 'h') {
                $array[] = [ucfirst($gen->genotypeCategory->gene_code), lcfirst($gen->genotypeCategory->gene_code)];
            } elseif ($gen->type == 'v') {
                if ($gen->genotypeCategory->gene_type == "r") {
                    $array[] = [lcfirst($gen->genotypeCategory->gene_code), lcfirst($gen->genotypeCategory->gene_code)];
                } else {
                    $array[] = [ucfirst($gen->genotypeCategory->gene_code), ucfirst($gen->genotypeCategory->gene_code)];
                }
            }
        }
        return $array;
    }

     public function getPairRows(int $femaleId, int $maleId): array
    {
        if (isset($this->finaleCache[$femaleId][$maleId])) {
            return $this->finaleCache[$femaleId][$maleId]['rows'];
        }

        // dogeneruj on-demand
        $femaleModel = $this->animalRepo->getById($femaleId);
        $maleModel   = $this->animalRepo->getById($maleId);

        $female = $this->getAnimalArray($femaleModel);
        $male   = $this->getAnimalArray($maleModel);

        $rows = getGenotypeFinale($male, $female, $this->dictionary);

        // uzupełnij cache i mapy nazw
        $this->malesMap[$maleModel->id] = $maleModel->name;
        $this->finaleCache[$femaleId][$maleId] = [
            'name' => $maleModel->name,
            'rows' => $rows,
        ];

        return $rows;
    }
    /*** ------ OBSŁUGA PAR ------ ***/

    public function pairKey($femaleId, $maleId): string
    {
        return "{$femaleId}:{$maleId}";
    }

    public function isChecked($femaleId, $maleId): bool
    {
        return isset($this->selectedPairs[$this->pairKey($femaleId, $maleId)]);
    }

    public function togglePair($femaleId, $maleId): void
    {
        if (empty($femaleId) || empty($maleId)) return;

        $key = $this->pairKey($femaleId, $maleId);

        if (isset($this->selectedPairs[$key])) {
            unset($this->selectedPairs[$key]);
        } else {
            $this->selectedPairs[$key] = [
                'female_id' => (int)$femaleId,
                'male_id'   => (int)$maleId,
            ];
        }
    }

    public function removePair($key): void
    {
        unset($this->selectedPairs[$key]);
    }

    public function clearPairs(): void
    {
        $this->selectedPairs = [];
    }

    public function openSummary(): void
    {
        $this->showSummary = true;
    }

    public function closeSummary(): void
    {
        $this->showSummary = false;
    }

    public function openAddLittersModal(): void
    {
        $this->showAddLitters = true;
    }

    public function closeAddLittersModal(): void
    {
        $this->showAddLitters = false;
    }

    public function addPlanningLitters(): void
    {
        // 1) Walidacja prostego roku i czy coś wybrano
        $this->validate([
            'plannedYear' => 'required|integer|min:2024|max:2100',
        ], [], [
            'plannedYear' => 'planowany rok',
        ]);

        if (empty($this->selectedPairs)) {
            // np. flash/emit — tu tylko przerwiemy:
            return;
        }

        $year = (int) $this->plannedYear;

        // 2) Iteracja po parach
        foreach ($this->selectedPairs as $key => $pair) {
            $femaleId = (int) $pair['female_id'];
            $maleId   = (int) $pair['male_id'];

            $litter = new Litter();
            $litter->category = 2;
            $litter->season = $year;
            $litter->litter_code = "PLAN";
            $litter->parent_male = $maleId;
            $litter->parent_female = $femaleId;
            $litter->save();
        }
        $this->closeAddLittersModal();
        $this->showAddLitters = false;
        $this->showSummary    = false;
        $this->plannedYear    = null;
        session()->flash('success', 'Plany miotów zapisane.');
    }

}
