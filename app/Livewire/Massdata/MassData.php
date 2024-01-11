<?php

namespace App\Livewire\Massdata;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalWeight;
use App\Models\Feed;
use Livewire\Attributes\On;
use Livewire\Component;

class MassData extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private FeedRepositoryInterface $feedRepo;
    public $title;
    public $category;
    public $mass = [];

    public function boot(AnimalRepositoryInterface $animalRepo, FeedRepositoryInterface $feedRepo)
    {
        $this->animalRepo = $animalRepo;
        $this->feedRepo = $feedRepo;
    }

    #[On('render')]
    public function render()
    {
        $this->setData();

        return view('livewire.massdata.mass-data', [
            'animals' => Animal::where('animal_category_id', $this->category)->get(),
            'feeds' => $this->feedRepo->all(),
        ]);
    }

    public function setData()
    {
        $animal = Animal::where('animal_category_id', $this->category)->get();
        foreach ($animal as $a) {
            $this->mass[$a->id]['feed'] = $a->feed_id;
            $this->mass[$a->id]['amount'] = 1;
            $this->mass[$a->id]['feedCheck'] = ($this->animalRepo->timeToFeed($a->id) <= 0) ? true : '';
        }
    }

    public function saveMassData()
    {
        foreach ($this->mass as $a => $value) {
            $animal = Animal::find($a);
            if ($value['feedCheck'] == true) {
                $feed = Feed::find($value['feed']);
                $feeding = new AnimalFeedings();
                $feeding->animal_id = $a;
                $feeding->feed_id = $value['feed'];
                $feeding->amount = $value['amount'];
                $feeding->save();

                $feed->amount -= $value['amount'];
                $feed->save();
                // dump($value['amount']);
            }
            if (!empty($value['weight'])) {
                $weight = new AnimalWeight();
                $weight->value = $value['weight'];
                $weight->animal_id = $a;
                $weight->save();
            }
        }

        return redirect(request()->header('Referer'));
    }
}
