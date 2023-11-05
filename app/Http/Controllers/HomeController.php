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
            'summary' => $this->animalToFeedSummary($this->animalToFeed()),
            'summaryLitters' => $this->animalToFeedSummary($this->animalToFeed(2)),
        ]);
    }


    public function animalToFeed(int $animalCategoryId = 1)
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

    public function animalToFeedSummary($animalArray)
    {
        if (!empty($animalArray)) {
            foreach ($animalArray ?? [] as $a) {
                $fName = Feed::find($a->animalFeed->id);
                $feed[] = $fName->name;
            }
            return array_count_values($feed);
        } else return [];
    }

    public function animalToWeight(int $animalCategoryId = 1)
    {

        $animal = [];
        $animals = Animal::where('animal_category_id', '=', $animalCategoryId)->get();
        foreach ($animals as $a) {
            if (timeToWeight($a->id) <= 1) {
                $animal[] = $a;
            }
        }

        return $animal;
    }
}
