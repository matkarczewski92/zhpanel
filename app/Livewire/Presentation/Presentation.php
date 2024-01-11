<?php

namespace App\Livewire\Presentation;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalWeight;
use App\Models\Feed;
use App\Models\Litter;
use Carbon\Carbon;
use Livewire\Component;

class Presentation extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private FeedRepositoryInterface $feedRepo;

    public $presentationOption;
    public $littersSelect;
    public $animalCount;
    public $step;
    public $animalList;
    public $index = 0;
    public $actual;
    public $feed_id = '';
    public $date = '';
    public $amount = 1;
    public $inputWeight = '';
    public $inputDate = '';
    public $feedIndicator = '';
    public $weightIndicator = '';
    public $ref = 0;

    public function boot(
        AnimalRepositoryInterface $animalRepo,
        FeedRepositoryInterface $feedRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->feedRepo = $feedRepo;
    }

    public function render()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->inputDate = Carbon::now()->format('Y-m-d');
        if ($this->presentationOption == 'litters' and $this->littersSelect != '') {
            $this->animalCount = Animal::where('litter_id', $this->littersSelect)->where('animal_category_id', 2)->count();
            $this->animalList = ($this->ref == 0) ? $this->animalLitterList() : $this->animalList;
            $this->ref = 1;
        } elseif ($this->presentationOption == 'all') {
            $this->animalCount = Animal::where('animal_category_id', 1)->count();
            $this->animalList = ($this->ref == 0) ? $this->animalList() : $this->animalList;
            $this->ref = 1;
        } elseif ($this->presentationOption == 'feed') {
            $this->animalCount = $this->toFeed('count');
            $this->animalList = ($this->ref == 0) ? $this->toFeed() : $this->animalList;
            $this->ref = 1;
        } else {
            $this->animalCount = '';
        }

        return view('livewire.presentation.presentation', [
            'litters' => Litter::where('category', 1)->get(),
            'data' => $this->animalList ?? [],
            'feeds' => Feed::all(),
            'animalRepo' => $this->animalRepo,
        ]);
    }

    public function secondStep()
    {
        $this->index = 0;
        $this->actual = Animal::find($this->animalList[0]);
        $this->feed_id = $this->actual->feed_id;
        $this->step = 2;
        $this->checkWeight();
        $this->checkFeeding();
    }

    public function nextStep()
    {
        ++$this->index;
        if ($this->animalCount > $this->index) {
            $this->actual = $this->animalRepo->getById($this->animalList[$this->index]);
            $this->feed_id = $this->actual->feed_id;
            $this->checkWeight();
            $this->checkFeeding();
        }
    }

    public function prevStep()
    {
        if ($this->index >= 0) {
            --$this->index;
            $this->actual = $this->animalRepo->getById($this->animalList[$this->index]);
            $this->feed_id = $this->actual->feed_id;
            $this->checkWeight();
            $this->checkFeeding();
        }
    }

    public function endPres()
    {
        $this->step = 1;
        $this->reset();
        $this->ref = 0;
    }

    public function toFeed($opt = null)
    {
        $animal = [];
        $animals = Animal::where('animal_category_id', '=', 1)->get();
        foreach ($animals as $a) {
            if ($this->animalRepo->timeToFeed($a->id) <= 1) {
                $animal[] = $a->id;
            }
        }

        $animals = Animal::where('animal_category_id', '=', 1)->get();
        foreach ($animals as $a) {
            if ($this->animalRepo->timeToWeight($a->id) <= 3) {
                $animal[] = $a->id;
            }
        }
        $resoult = array_unique($animal);
        asort($resoult);

        foreach ($resoult ?? [] as $r) {
            $return[] = $r;
        }

        $return = ($opt == 'count') ? $return['count'] = count($return) : $return['id'] = $return;

        return $return;
    }

    public function animalList()
    {
        $animal = [];
        $data = Animal::where('animal_category_id', 1)->get();
        foreach ($data ?? [] as $r) {
            $animal[] = $r->id;
        }

        return $animal;
    }

    public function animalLitterList()
    {
        $animal = [];
        $data = Animal::where('litter_id', $this->littersSelect)->where('animal_category_id', 2)->get();
        foreach ($data ?? [] as $r) {
            $animal[] = $r->id;
        }

        return $animal;
    }

    public function storeFeed()
    {
        $feed = Feed::find($this->feed_id);

        if ($this->amount <= $feed->amount) {
            if ($this->date == '') {
                $date = Carbon::now()->format('Y-m-d');
            } else {
                $date = $this->date;
            }
            $feeding = new AnimalFeedings();
            $feeding->animal_id = $this->actual->id;
            $feeding->feed_id = $this->feed_id;
            $feeding->amount = $this->amount;
            $feeding->created_at = $this->date;
            $feeding->save();

            $feed->amount -= $this->amount;
            $feed->save();
            session()->flash('animalFeedingColor', 'text-success');
            $this->reset('amount');
        }
        $this->checkWeight();
        $this->checkFeeding();
    }

    public function addWeight()
    {
        if ($this->inputDate == '') {
            $date = Carbon::now()->format('Y-m-d');
        } else {
            $date = $this->inputDate;
        }
        $weight = new AnimalWeight();
        $weight->animal_id = $this->actual->id;
        $weight->created_at = $date;
        $weight->value = $this->inputWeight;
        $weight->save();
        $this->reset('inputDate');
        $this->reset('inputWeight');
        session()->flash('animalWeightColor', 'text-success');
        $this->checkWeight();
        $this->checkFeeding();
    }

    public function checkFeeding()
    {
        $nowDate = Carbon::now();
        $nextFeedDate = $this->animalRepo->nextFeed($this->actual->id);
        $diff = Carbon::parse($nowDate)->diffInDays(Carbon::parse($nextFeedDate), false);
        if ($diff <= 0) {
            $this->feedIndicator = 'text-danger';
        } else {
            $this->feedIndicator = '';
        }
    }

    public function checkWeight()
    {
        $weight = AnimalWeight::where('animal_id', '=', $this->actual->id)->orderBy('created_at', 'desc')->first();
        $nowDate = Carbon::now();
        if (!empty($weight->created_at)) {
            $lastWeightDate = new Carbon($weight->created_at);
            $diff = $lastWeightDate->diff($nowDate)->days;
            if ($diff >= 25) {
                $this->weightIndicator = 'text-danger';
            } else {
                $this->weightIndicator = '';
            }
        } else {
            $this->weightIndicator = '';
        }
    }
}
