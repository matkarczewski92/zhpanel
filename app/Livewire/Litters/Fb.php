<?php

namespace App\Livewire\Litters;

use App\Models\Animal;
use App\Models\Litter;
use App\Services\FacebookService;
use Livewire\Component;

class Fb extends Component
{
    public int|string $litterId;
    public string $adnotation = '';
    public string $status = '';

    // USTAW startowe dane TYLKO raz
    public function mount($litterId): void
    {
    }

    public function render()
    {
        $litter = Litter::find($this->litterId);

        return view('livewire.litters.fb', [
            'litter' => $litter,
        ]);
    }

    public function save()
    {

    }

    
}
