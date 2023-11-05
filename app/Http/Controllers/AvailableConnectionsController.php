<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Litter;
use Illuminate\Http\Request;

class AvailableConnectionsController extends Controller
{

    public function index()
    {

        return view('available-connections', [
            'females' => Animal::where('sex', 3)->where('animal_category_id', 1)->get(),
            'males' => Animal::where('sex', 2)->where('animal_category_id', 1)->get(),

        ]);
    }

    public function show(string $id)
    {
        $litter = Litter::find($id);
        return view('litters.litters-profile', [
            'litter' => $litter,
            'category' => litterCategory($litter->category),
            'animals' => Animal::where('litter_id', $id)->get(),
        ]);
    }
}
