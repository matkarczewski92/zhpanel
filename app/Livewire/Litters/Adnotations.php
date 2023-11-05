<?php

namespace App\Livewire\Litters;

use App\Models\Litter;
use App\Models\LitterAdnotations;
use Livewire\Component;

class Adnotations extends Component
{
    public $litterId, $adnotation, $status = '';

    public function render()
    {
        $litterAdnotation = Litter::find($this->litterId);
        $this->adnotation = $litterAdnotation->litterAdnotations?->adnotation;
        // dd($litterAdnotation);
        return view('livewire.litters.adnotations', [
            'litter' => $litterAdnotation,
        ]);
    }

    public function save()
    {
        $adn = LitterAdnotations::where('litter_id', $this->litterId)->first();
        if (!empty($this->adnotation)) {
            if (is_null($adn)) {
                $adn = new LitterAdnotations();
                $adn->litter_id = $this->litterId;
            }
            $adn->adnotation = $this->adnotation;
            $adn->save();
            $this->status = 'ok';
        } else {
            if (!is_null($adn)) {
                $adn->delete();
                $this->status = 'ok';
            }
        }
    }
}
