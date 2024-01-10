<?php

namespace App\Livewire\Animal;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use Livewire\Attributes\On;
use Livewire\Component;

class AnimalProfileDetails extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    private FeedRepositoryInterface $feedRepo;

    public $animalId = '';
    public $feedId = '';
    public $sex = '';

    public function mount(
        AnimalRepositoryInterface $animalRepo,
        FeedRepositoryInterface $feedRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->feedRepo = $feedRepo;
    }

    #[On('animal-profile-details')]
    public function render()
    {
        return view('livewire.animal.animal-profile-details', [
            'animal' => $this->animalRepo->getById($this->animalId),
            'feedInterval' => $this->animalRepo->feedInterval($this->animalId),
            'lastFeeding' => $this->animalRepo->lastFeed($this->animalId),
            'nextFeed' => $this->animalRepo->nextFeed($this->animalId),
            'feed' => $this->feedRepo->getById($this->feedId),
            'sexName' => $this->animalRepo->sexName($this->sex),
        ]);
    }
}
