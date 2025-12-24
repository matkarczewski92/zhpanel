<?php

namespace App\Livewire\Litters;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalGenotypeCategory;
use App\Models\Litter;
use App\Models\LitterPlan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PossibleConnectionController extends Component
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public $females = [];
    public $femalesMap = [];
    public $malesMap = [];

    public $finale = [];
    public $finaleCache = [];

    public $selectedFemale = null;
    public $selectedPairs = [];
    public $showSummary = false;
    public $pairedFemaleIds = [];
    public $plannedYear = null;

    public $activeTab = 'builder';
    public $planName = '';
    public $editingPlanId = null;
    public $saveMessage = null;
    public $showPlanRealizeModal = false;
    public $planToRealizeId = null;

    public $dictionary;

    public function boot(
        LitterRepositoryInterface $litterRepo,
        AnimalRepositoryInterface $animalRepo
    ): void {
        $this->litterRepo = $litterRepo;
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        $this->dictionary = $this->getDictionary();
        $this->females    = $this->animalRepo->getAllInBreedingFemales();
        $this->femalesMap = $this->females->pluck('name', 'id')->toArray();
        $this->malesMap = $this->males->pluck('name', 'id')->toArray();

        $this->pairedFemaleIds = array_values(array_unique(
            array_map(fn ($pair) => (int) $pair['female_id'], $this->selectedPairs)
        ));

        return view('livewire.litters.possible-connection-controller', [
            'animalRepo' => $this->animalRepo,
            'plans'      => LitterPlan::with(['pairs.female', 'pairs.male'])->orderByDesc('updated_at')->get(),
        ]);
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

        if (isset($this->finaleCache[$femaleId])) {
            $this->finale = $this->finaleCache[$femaleId];
            return;
        }

        $possibleCombinations = [];

        $femaleModel = $this->animalRepo->getById($femaleId);
        $female      = $this->getAnimalArray($femaleModel);
        $males       = $this->animalRepo
            ->getAllInBreedingMales()
            ->where('animal_type_id', $femaleModel->animal_type_id);

        foreach ($males as $maleModel) {
            $maleData         = $this->getAnimalArray($maleModel);
            $finalCombinations = getGenotypeFinale($maleData, $female, $this->dictionary);

            $this->malesMap[$maleModel->id] = $maleModel->name;

            $possibleCombinations[$maleModel->id] = [
                'name' => $maleModel->name,
                'rows' => $finalCombinations,
            ];
        }

        $this->finale = $possibleCombinations;
        $this->finaleCache[$femaleId] = $possibleCombinations;
    }

    public function getDictionary()
    {
        $genes = AnimalGenotypeCategory::all();
        $dictionary = [];

        foreach ($genes as $gene) {
            $dictionary[] = [$gene->gene_code, $gene->name];
        }

        return $dictionary;
    }

    public function getAnimalArray($animal)
    {
        $genotype = $animal->animalGenotype;
        $result = [];

        foreach ($genotype as $gene) {
            if ($gene->type === 'h') {
                $result[] = [ucfirst($gene->genotypeCategory->gene_code), lcfirst($gene->genotypeCategory->gene_code)];
            } elseif ($gene->type === 'v') {
                if ($gene->genotypeCategory->gene_type === 'r') {
                    $result[] = [lcfirst($gene->genotypeCategory->gene_code), lcfirst($gene->genotypeCategory->gene_code)];
                } else {
                    $result[] = [ucfirst($gene->genotypeCategory->gene_code), ucfirst($gene->genotypeCategory->gene_code)];
                }
            }
        }

        return $result;
    }

    public function getPairRows(int $femaleId, int $maleId): array
    {
        if (isset($this->finaleCache[$femaleId][$maleId])) {
            if (!isset($this->malesMap[$maleId]) && isset($this->finaleCache[$femaleId][$maleId]['name'])) {
                $this->malesMap[$maleId] = $this->finaleCache[$femaleId][$maleId]['name'];
            }
            return $this->finaleCache[$femaleId][$maleId]['rows'];
        }

        $femaleModel = $this->animalRepo->getById($femaleId);
        $maleModel   = $this->animalRepo->getById($maleId);

        $female = $this->getAnimalArray($femaleModel);
        $male   = $this->getAnimalArray($maleModel);

        $rows = getGenotypeFinale($male, $female, $this->dictionary);

        $this->malesMap[$maleId] = $maleModel->name;
        $this->finaleCache[$femaleId][$maleId] = [
            'name' => $this->malesMap[$maleId],
            'rows' => $rows,
        ];

        return $rows;
    }

    public function resolveMaleName(int $maleId): string
    {
        $maleId = (int) $maleId;

        if (!isset($this->malesMap[$maleId])) {
            $maleModel = $this->animalRepo->getById($maleId);

            if ($maleModel) {
                $this->malesMap[$maleId] = $maleModel->name;
            }
        }

        return $this->malesMap[$maleId] ?? ('ID: '.$maleId);
    }

    public function maleUsedTimes(int $maleId): int
    {
        return count(array_filter(
            $this->selectedPairs,
            fn ($pair) => (int) $pair['male_id'] === (int) $maleId
        ));
    }

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
        if (empty($femaleId) || empty($maleId)) {
            return;
        }

        $key = $this->pairKey($femaleId, $maleId);

        if (isset($this->selectedPairs[$key])) {
            unset($this->selectedPairs[$key]);
            $this->refreshFemaleFinale((int) $femaleId);
        } else {
            $this->selectedPairs[$key] = [
                'female_id' => (int) $femaleId,
                'male_id'   => (int) $maleId,
            ];
        }
    }

    public function removePair($key): void
    {
        if (!isset($this->selectedPairs[$key])) {
            return;
        }

        $femaleId = (int) $this->selectedPairs[$key]['female_id'];

        unset($this->selectedPairs[$key]);

        $this->refreshFemaleFinale($femaleId);
    }

    public function clearPairs(): void
    {
        $currentFemale = $this->selectedFemale ? (int) $this->selectedFemale : null;

        $this->selectedPairs = [];

        if (!is_null($currentFemale)) {
            $this->refreshFemaleFinale($currentFemale);
        }
    }

    public function openSummary(): void
    {
        $this->saveMessage = null;
        $this->showSummary = true;
    }

    public function closeSummary(): void
    {
        $this->showSummary = false;
    }

    public function setActiveTab(string $tab): void
    {
        if (!in_array($tab, ['builder', 'plans'], true)) {
            return;
        }

        $this->activeTab = $tab;

        if ($tab === 'plans') {
            $this->showSummary = false;
        }
    }

    public function newPlan(): void
    {
        $this->selectedPairs = [];
        $this->planName = '';
        $this->plannedYear = null;
        $this->editingPlanId = null;
        $this->selectedFemale = null;
        $this->showSummary = false;
        $this->activeTab = 'builder';
        $this->saveMessage = null;
        $this->finale = [];
        $this->finaleCache = [];
    }

    public function savePlan(): void
    {
        $this->validate([
            'planName'    => 'required|string|min:3|max:255',
            'plannedYear' => 'nullable|integer|min:0|max:2100',
        ], [], [
            'planName'    => 'nazwa planu',
            'plannedYear' => 'planowany rok',
        ]);

        if (empty($this->selectedPairs)) {
            $this->addError('planName', 'Brak wybranych par do zapisania.');
            return;
        }

        DB::transaction(function () {
            $plan = LitterPlan::updateOrCreate(
                ['id' => $this->editingPlanId],
                [
                    'name'         => $this->planName,
                    'planned_year' => $this->plannedYear ?: null,
                ]
            );

            $plan->pairs()->delete();

            foreach ($this->selectedPairs as $pair) {
                $plan->pairs()->create([
                    'female_id' => (int) $pair['female_id'],
                    'male_id'   => (int) $pair['male_id'],
                ]);
            }

            $this->editingPlanId = $plan->id;
            $this->plannedYear = $plan->planned_year;
        });

        $this->saveMessage = 'Plan zapisano poprawnie.';
        $this->showSummary = false;
        $this->setActiveTab('plans');
    }

    public function loadPlan(int $planId): void
    {
        $plan = LitterPlan::with('pairs')->findOrFail($planId);

        $pairs = [];
        foreach ($plan->pairs as $pair) {
            $key = $this->pairKey($pair->female_id, $pair->male_id);
            $pairs[$key] = [
                'female_id' => (int) $pair->female_id,
                'male_id'   => (int) $pair->male_id,
            ];
        }

        $this->selectedPairs = $pairs;
        $this->planName = $plan->name;
        $this->plannedYear = $plan->planned_year;
        $this->editingPlanId = $plan->id;
        $this->selectedFemale = null;
        $this->showSummary = true;
        $this->setActiveTab('builder');
        $this->saveMessage = null;
        $this->finale = [];
        $this->finaleCache = [];
    }

    public function deletePlan(int $planId): void
    {
        $plan = LitterPlan::find($planId);

        if (!$plan) {
            return;
        }

        $plan->delete();

        if ($this->editingPlanId === $planId) {
            $this->editingPlanId = null;
            $this->planName = '';
            $this->plannedYear = null;
        }
    }

    public function requestRealizePlan(int $planId): void
    {
        $plan = LitterPlan::withCount('pairs')->find($planId);

        if (!$plan || $plan->pairs_count === 0) {
            return;
        }

        $this->planToRealizeId = $plan->id;
        $this->plannedYear = $plan->planned_year;
        $this->showPlanRealizeModal = true;
        $this->saveMessage = null;
    }

    public function cancelRealizePlan(): void
    {
        $this->showPlanRealizeModal = false;
        $this->planToRealizeId = null;
        $this->plannedYear = null;
    }

    public function realizePlan(): void
    {
        if (!$this->planToRealizeId) {
            return;
        }

        $this->validate([
            'plannedYear' => 'nullable|integer|min:0|max:2100',
        ], [], [
            'plannedYear' => 'planowany rok',
        ]);

        $plan = LitterPlan::with('pairs')->find($this->planToRealizeId);

        if (!$plan || $plan->pairs->isEmpty()) {
            $this->cancelRealizePlan();
            return;
        }

        $year = (int) $this->plannedYear;

        DB::transaction(function () use ($plan, $year) {
            foreach ($plan->pairs as $pair) {
                $femaleId = (int) $pair->female_id;
                $maleId   = (int) $pair->male_id;

                $litter = new Litter();
                $litter->category = 2;
                $litter->season = ($year === 0) ? null : $year;
                $litter->litter_code = litterCode($maleId, $femaleId, $year);
                $litter->parent_male = $maleId;
                $litter->parent_female = $femaleId;
                $litter->save();
            }

            $plan->planned_year = ($year === 0) ? null : $year;
            $plan->save();
        });

        $this->cancelRealizePlan();
        redirect()->route('litters.index');
    }

    private function refreshFemaleFinale(int $femaleId): void
    {
        unset($this->finaleCache[$femaleId]);

        if ((int) $this->selectedFemale === $femaleId) {
            $this->createFinale($femaleId);
        }
    }
}
