<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Wintering;
use Illuminate\Contracts\View\View;

class WinteringController extends Controller
{
    public function index(): View
    {
        return view('winterings', [
            'winterings' => $this->getAnimals(),
        ]);
    }

    public function getAnimals()
    {
        $animals = Animal::all();
        foreach ($animals as $animal) {
            $count = Wintering::where('animal_id', $animal->id)->where('archive', null)->count();
            if ($count != 0) {
                $return[] = $animal;
            }
        }

        return $return ?? [];
    }
}
