<?php

namespace App\Livewire\Offer;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\AnimalOffer;
use Livewire\Component;

class Offer extends Component
{
    private AnimalRepositoryInterface $animalRepo;

    public function boot(
        AnimalRepositoryInterface $animalRepo,
    ) {
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        return view('livewire.offer.offer', [
            'offers' => $this->animalRepo->getUnsoldOffer(),
            'title' => 'Oferty sprzedaży',
            'sum' => $this->getSumPrice(),
            'repo' => $this->animalRepo,
        ]);
    }

    public function publicProfileSwitch(int $animalId)
    {
        $animal = $this->animalRepo->getById($animalId);
        $switch = ($animal->public_profile == '0') ? '1' : '0';
        $animal->public_profile = $switch;
        $animal->save();
    }

    public function getSumPrice()
    {
        return $sum = AnimalOffer::where('sold_date', null)->sum('price');
    }
}
