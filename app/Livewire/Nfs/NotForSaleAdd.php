<?php

namespace App\Livewire\Nfs;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Litter;
use App\Models\LittersPairing;
use App\Models\NotForSale;
use Livewire\Component;

class NotForSaleAdd extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public $litter;
    public $animal;
    public $sex;
    public $annotations;

    public function boot(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    public function render()
    {
        return view('livewire.nfs.not-for-sale-add', [
            'litters' => $this->litters(),
            'animals' => $this->animals($this->litter),
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
        ]);
    }

    public function litters()
    {
        $pairings = LittersPairing::join('litters', function ($join) {
            $join->on('litters_pairings.litter_id', '=', 'litters.id')
            ->where(function ($lt) {
                $lt->where('litters.category', '=', '1')
                ->orWhere('litters.category', '=', '2');
            });
        })
        ->groupBy('litters.id')
        ->get();

        return $pairings;
    }

    public function animals($litterId = null)
    {
        if (!is_null($litterId)) {
            $pairings = Litter::where('litters.id', $litterId)->where(function ($lt) {
                $lt->where('litters.category', '=', '1')
                ->orWhere('litters.category', '=', '2');
            })
                    ->join('litters_pairings', function ($join) {
                        $join->on('litters.id', '=', 'litters_pairings.litter_id');
                    })
                    ->get();
        }

        return $pairings ?? [];
    }

    public function addNfs()
    {
        $nfs = new NotForSale();
        $nfs->pairing_id = $this->animal;
        $nfs->sex = $this->sex;
        $nfs->annotations = $this->annotations;
        $nfs->save();

        return redirect()->to('/not-for-sale');
    }
}
