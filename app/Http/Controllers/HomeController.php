<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\Litter;

class HomeController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    public function index()
    {
        $animalsToFeed = $this->animalToFeed();
        $littersToFeed = $this->animalToFeed(2);
        $animalsToWeight = $this->animalToWeight();
        $littersToWeight = $this->animalToWeight(2);

        return view('home', [
            'animal' => $animalsToFeed,
            'litter' => $littersToFeed,
            'toWeight' => $animalsToWeight,
            'toWeightLitters' => $littersToWeight,
            'summary' => $this->animalToFeedSummary($animalsToFeed, 0),
            'summaryLitters' => $this->animalToFeedSummary($littersToFeed, 0),
            'summaryPast' => $this->animalToFeedSummary($animalsToFeed, 1),
            'summaryLittersPast' => $this->animalToFeedSummary($littersToFeed, 1),
            'littersStatus' => $this->litterStatus(),
            'summary_info' => $this->info_data(),
        ]);
    }

    public function animalToFeed(int $animalCategoryId = 1): array
    {
        $animal = [];
        $animals = Animal::with('animalFeed')
            ->where('animal_category_id', '=', $animalCategoryId)
            ->get();
        foreach ($animals as $a) {
            $timeToFeed = $this->animalRepo->timeToFeed($a->id);
            if ($timeToFeed <= 1) {
                $a->setAttribute('time_to_feed', $timeToFeed);
                $a->setAttribute('next_feed_date', $this->animalRepo->nextFeed($a->id));
                $animal[] = $a;
            }
        }

        return $animal;
    }

    public function animalToFeedSummary($animalArray, int $fn = 0): array
    {
        $feed = [];
        if (!empty($animalArray)) {
            foreach ($animalArray ?? [] as $a) {
                $timeToFeed = $a->time_to_feed ?? $this->animalRepo->timeToFeed($a->id);
                if ($fn == 1) {
                    if ($timeToFeed <= 0) {
                        $feed[] = $a->animalFeed?->name ?? '';
                    }
                } elseif ($fn == 0) {
                    $feed[] = $a->animalFeed?->name ?? '';
                }
            }

            return array_count_values($feed);
        } else {
            return [];
        }
    }

    public function animalToWeight(int $animalCategoryId = 1): array
    {
        $animal = [];
        $animals = Animal::where('animal_category_id', '=', $animalCategoryId)->get();
        foreach ($animals as $a) {
            $timeToWeight = $this->animalRepo->timeToWeight($a->id);
            if ($timeToWeight <= 3) {
                $a->setAttribute('time_to_weight', $timeToWeight);
                $a->setAttribute('last_weight_value', $this->animalRepo->lastWeight($a->id));
                $a->setAttribute('last_weighting_date', $this->animalRepo->lastWeighting($a->id));
                $animal[] = $a;
            }
        }

        return $animal;
    }

    public function litterStatus(): array
    {
        $littersLaying = Litter::where('category', 1)
        ->where('connection_date', '!=', null)
        ->where('laying_date', null)
        ->orderBy('connection_date')
        ->get();

        $littersHatching = Litter::where('category', 1)
        ->where('connection_date', '!=', null)
        ->where('laying_date', '!=', null)
        ->where('hatching_date', null)
        ->orderBy('connection_date')
        ->get();

        return $return = [
                    'laying' => $littersLaying,
                    'hatching' => $littersHatching,
                ];
    }

    public function info_data(){

            
            $summary['litter_count'] = Litter::where('category', 1)->count();
            $summary['eggs_count'] = Litter::whereNotNull('laying_date')->whereNull('hatching_date')->sum('laying_eggs_ok');
            $summary['for_sale'] = Animal::where('animal_category_id', '=', 2)->count();
            $summary['this_year'] = Litter::where('category', 1)->whereNotNull('laying_date')->whereNull('hatching_date')->sum('laying_eggs_ok')+Litter::where('category', 1)->whereNotNull('laying_date')->whereNotNull('hatching_date')->sum('laying_eggs_ok');
    
            return $summary;
        
    }
}
