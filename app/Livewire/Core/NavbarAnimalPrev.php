<?php

namespace App\Livewire\Core;

use App\Interfaces\AnimalRepositoryInterface;
use Livewire\Component;

class NavbarAnimalPrev extends Component
{
    private AnimalRepositoryInterface $animalRepo;
    public $firstSegment, $secondSegment;


    public function boot(
        AnimalRepositoryInterface $animalRepo,

    ) {
        $this->animalRepo = $animalRepo;
    }

    public function render()
    {
        $this->firstSegment = request()->segment(1);
        $this->secondSegment = request()->segment(2);
        return view('livewire.core.navbar-animal-prev',[
            'prev' => $this->getPrev(),
            'next' => $this->getNext()
        ]);
    }

    public function getPrev(){
        $array = $this->getAnimalArray($this->firstSegment);
        if($array!=null)
        {
            $this->secondSegment = request()->segment(2);
            $key = array_search($this->secondSegment, $array);
            if ($key !== false) {
                $before = $array[$key - 1] ?? null;  // Wartość przed, zabezpieczone, żeby nie wyszło poza zakres tablicy
            }
            return $before ?? '';
        }
    }
    public function getNext(){
        $array = $this->getAnimalArray($this->firstSegment);
        if($array!=null)
        {
            $this->secondSegment = request()->segment(2);
            $key = array_search($this->secondSegment, $array);
            if ($key !== false) {
                $after = $array[$key + 1] ?? null;  // Wartość przed, zabezpieczone, żeby nie wyszło poza zakres tablicy
            }
            return $after ?? '';
        }
    }
    public function getAnimalArray(){
        $category = $this->getActualAnimalCategoriId($this->secondSegment);
        return $this->animalRepo->getAllByCategory($category)->pluck('id')->toArray();
    }

    public function getActualAnimalCategoriId(?int $animalId){
        if($animalId){
            $actualAnimal = $this->animalRepo->getById($animalId);
            return $actualAnimal->animal_category_id;
        } else return 1;
    }
}
