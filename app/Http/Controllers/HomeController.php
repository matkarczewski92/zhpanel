<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{


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
        ]);
    }


    public function animalToFeed(int $animalCategoryId = 1): array
    {

        $animal = [];
        $animals = Animal::where('animal_category_id', '=', $animalCategoryId)->get();
        foreach ($animals as $a) {
            if (timeToFeed($a->id) <= 1) {
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
                    if (timeToFeed($a->id) <= 0) {
                        $fName = Feed::find($a->animalFeed->id);
                        $feed[] = $fName->name;
                    }
                } else if ($fn == 0) {
                    $fName = Feed::find($a->animalFeed->id);
                    $feed[] = $fName->name;
                }
            }
            return array_count_values($feed);
        } else return [];
    }

    public function animalToWeight(int $animalCategoryId = 1): array
    {

        $animal = [];
        $animals = Animal::where('animal_category_id', '=', $animalCategoryId)->get();
        foreach ($animals as $a) {
            if (timeToWeight($a->id) <= 3) {
                $animal[] = $a;
            }
        }

        return $animal;
    }
}
