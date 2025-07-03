<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\Feed;
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
        return view('home', [
            'animal' => $this->animalToFeed(),
            'litter' => $this->animalToFeed(2),
            'toWeight' => $this->animalToWeight(),
            'toWeightLitters' => $this->animalToWeight(2),
            'summary' => $this->animalToFeedSummary($this->animalToFeed(), 0),
            'summaryLitters' => $this->animalToFeedSummary($this->animalToFeed(2), 0),
            'summaryPast' => $this->animalToFeedSummary($this->animalToFeed(), 1),
            'summaryLittersPast' => $this->animalToFeedSummary($this->animalToFeed(2), 1),
            'littersStatus' => $this->litterStatus(),
            'animalRepo' => $this->animalRepo,
            'summary_info' => $this->info_data(),
        ]);
    }

    public function animalToFeed(int $animalCategoryId = 1): array
    {
        $animal = [];
        $animals = Animal::where('animal_category_id', '=', $animalCategoryId)->get();
        foreach ($animals as $a) {
            if ($this->animalRepo->timeToFeed($a->id) <= 1) {
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
                if ($fn == 1) {
                    if ($this->animalRepo->timeToFeed($a->id) <= 0) {
                        $fName = Feed::find($a->animalFeed?->id);
                        $feed[] = $fName->name ?? '';
                    }
                } elseif ($fn == 0) {
                    $fName = Feed::find($a->animalFeed?->id) ?? [];
                    $feed[] = $fName->name ?? '';
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
            if ($this->animalRepo->timeToWeight($a->id) <= 3) {
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
            $summary['this_year'] = Litter::whereNotNull('laying_date')->whereNull('hatching_date')->sum('laying_eggs_ok')+Litter::whereNotNull('laying_date')->whereNotNull('hatching_date')->sum('laying_eggs_ok');
    
            return $summary;
        
    }
}
