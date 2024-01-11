<?php

namespace App\Livewire\Animal;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalWeight;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class AnimalProfileSidebar extends Component
{
    private AnimalRepositoryInterface $animalRepo;

    public $animalId = '';
    public $feedIndicator = '';
    public $feedIndicatorColor = '#c5cad3';
    public $feedDiff = '';
    public $weightIndicator = '';
    public $weightIndicatorColor = '#c5cad3';

    public function boot(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    #[On('animal-sidebar-render')]
    public function render()
    {
        $this->checkWeight();
        $this->checkFeeding();

        return view('livewire.animal.animal-profile-sidebar', [
            'animal' => Animal::find($this->animalId),
        ]);
    }

    public function publicProfileSwitch()
    {
        $animal = Animal::find($this->animalId);
        $switch = ($animal->public_profile == '0') ? '1' : '0';
        $animal->public_profile = $switch;
        $animal->save();
    }

    public function checkFeeding()
    {
        $nowDate = Carbon::now();
        $nextFeedDate = $this->animalRepo->nextFeed($this->animalId);
        $feedingDate = new Carbon($nextFeedDate);
        // $diff = $nowDate->diff($feedingDate)->days;
        $diff = Carbon::parse($nowDate)->diffInDays(Carbon::parse($nextFeedDate), false);
        if ($diff == 0) {
            $this->feedIndicator = 'fa-bounce';
            $this->feedIndicatorColor = '#e7b50f';
        } elseif ($diff < 0) {
            $this->feedIndicator = 'fa-bounce';
            $this->feedIndicatorColor = '#b41d1d';
        } else {
            $this->feedIndicator = '';
            $this->feedIndicatorColor = '#c5cad3';
        }
        $this->feedDiff = $diff;
    }

    public function checkWeight()
    {
        $weight = AnimalWeight::where('animal_id', '=', $this->animalId)->orderBy('created_at', 'desc')->first();
        $nowDate = Carbon::now();
        if (!empty($weight->created_at)) {
            $lastWeightDate = new Carbon($weight->created_at);
            $diff = $lastWeightDate->diff($nowDate)->days;
            if ($diff >= 25) {
                $this->weightIndicator = 'fa-bounce';
                $this->weightIndicatorColor = '#b41d1d';
            } else {
                $this->weightIndicator = '';
                $this->weightIndicatorColor = '#c5cad3';
            }
        } else {
            $this->weightIndicator = 'fa-bounce';
            $this->weightIndicatorColor = '#e7b50f';
        }
    }
}
