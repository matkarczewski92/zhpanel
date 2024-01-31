<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\AnimalFeedings;
use App\Models\AnimalGenotype;
use App\Models\AnimalMolt;
use App\Models\AnimalWeight;

class WebSideProfile extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private FeedRepositoryInterface $feedRepo;

    public function __invoke(
        AnimalRepositoryInterface $animalRepo,
        FeedRepositoryInterface $feedRepo,
    ) {
        $this->animalRepo = $animalRepo;
        $this->feedRepo = $feedRepo;
        $animal = $this->animalRepo->getByToken(request()->route('id'));

        if ($animal->public_profile == 0) {
            return redirect('webpage');
        } else {
            return view('webside-profile', [
                'animal' => $animal,
                'animalFeedings' => AnimalFeedings::where('animal_id', $animal->id)->orderBy('created_at', 'desc')->paginate(10, ['*'], 'feedingsPaginate'),
                'feedInterval' => $this->animalRepo->feedInterval($animal->id),
                'lastFeeding' => $this->animalRepo->lastFeed($animal->id),
                'nextFeed' => $this->animalRepo->nextFeed($animal->id),
                'feed' => $this->feedRepo->getById($animal->feed_id),
                'sexName' => $this->animalRepo->sexName($animal->sex),
                'weightHistory' => AnimalWeight::where('animal_id', '=', $animal->id)->orderBy('created_at', 'desc')->paginate(5, ['*'], 'weightPaginate'),
                'molts' => AnimalMolt::where('animal_id', '=', $animal->id)->orderBy('created_at', 'desc')->paginate(5, ['*'], 'moltPaginate'),
                'genotypeVis' => $this->animalGenotype('v', $animal->id),
                'genotypeHet' => $this->animalGenotype('h', $animal->id),
                'genotypePos' => $this->animalGenotype('p', $animal->id),
            ]);
        }
    }

    public function animalGenotype(string $type, int $animalId)
    {
        return AnimalGenotype::where('animal_id', '=', $animalId)->where('type', '=', $type)->get();
    }
}
