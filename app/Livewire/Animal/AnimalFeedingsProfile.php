<?php

namespace App\Livewire\Animal;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\AnimalFeedings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AnimalFeedingsProfile extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private FeedRepositoryInterface $feedRepo;

    public $animalId = '';
    public $animal_id = '';
    public $feed_id = '';
    public $date = '';
    public $amount = 1;
    public $editMode = 0;
    public $editBtnMode = 'success';

    public function boot(
        AnimalRepositoryInterface $animalRepo,
        FeedRepositoryInterface $feedRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->feedRepo = $feedRepo;
    }

    #[On('render')]
    public function render()
    {
        $animal = $this->animalRepo->getById($this->animalId);
        $this->feed_id = $animal->feed_id;
        $this->date = Carbon::now()->format('Y-m-d');

        return view('livewire.animal.animal-feedings-profile', [
            'feeds' => $this->feedRepo->all(),
            'animal' => $animal,
            'feedings' => $this->showFeedings($this->animalId),
        ]);
    }

    public function store()
    {
        $feed = $this->feedRepo->getById($this->feed_id);
        if ($this->amount <= $feed->amount) {
            if ($this->date == '') {
                $date = Carbon::now()->format('Y-m-d');
            } else {
                $date = $this->date;
            }
            $feeding = new AnimalFeedings();
            $feeding->animal_id = $this->animalId;
            $feeding->feed_id = $this->feed_id;
            $feeding->amount = $this->amount;
            $feeding->created_at = $this->date;
            $feeding->save();

            $feed->amount -= $this->amount;
            $feed->save();

            $this->dispatch('animal-profile-details')->to(AnimalProfileDetails::class);
            $this->dispatch('animal-sidebar-render')->to(AnimalProfileSidebar::class);
            $this->reset('feed_id');
            $this->reset('amount');
            session()->flash('animalFeeding', 'Karmienie zostało dodane');
            session()->flash('animalFeedingColor', 'success');
        } else {
            session()->flash('animalFeeding', 'Taka ilośc karmy nie jest dostępna.');
            session()->flash('animalFeedingColor', 'danger');
        }
    }

    public function delete(int $feedingId)
    {
        $feeding = AnimalFeedings::find($feedingId);
        if (!empty($feeding->id)) {
            $feeding->delete();
        }
        session()->flash('animalFeeding', 'Pozycja została usunięta');
        session()->flash('animalFeedingColor', 'danger');
        $this->dispatch('animal-profile-details')->to(AnimalProfileDetails::class);
        $this->dispatch('animal-sidebar-render')->to(AnimalProfileSidebar::class);
    }

    public function showFeedings(int $animalId): array
    {
        $yearTab = [];
        $feedingsYear = AnimalFeedings::where('animal_id', $animalId)->select(DB::raw('DATE_FORMAT(created_at, "%Y") as year'))->groupBy('year')->orderBy('year', 'desc')->get();
        $feedingsMonth = AnimalFeedings::where('animal_id', $animalId)->select(DB::raw('DATE_FORMAT(created_at, "%m") as month'))->groupBy('month')->orderBy('month', 'desc')->get();

        foreach ($feedingsYear as $year) {
            foreach ($feedingsMonth as $mont) {
                $check = AnimalFeedings::where('animal_id', $animalId)->whereMonth('created_at', '=', $mont->month)->whereYear('created_at', '=', $year->year)->orderBy('created_at', 'desc')->get();
                if (count($check) != 0) {
                    $yearTab[$year->year][$year->year.'-'.$mont->month][] = $check;
                }
            }
        }

        return $yearTab;
    }

    public function editModeSwitch()
    {
        if ($this->editMode == 0) {
            $this->editMode = 1;
            $this->editBtnMode = 'danger';
        } else {
            $this->editMode = 0;
            $this->editBtnMode = 'success';
        }
    }
}
