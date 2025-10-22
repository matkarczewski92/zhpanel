<?php

namespace App\Repository;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalOffer;
use App\Models\AnimalWeight;
use App\Models\Feed;
use Carbon\Carbon;

class AnimalRepository implements AnimalRepositoryInterface
{
    protected array $feedIntervalCache = [];
    protected array $lastFeedCache = [];
    protected array $nextFeedCache = [];
    protected array $timeToFeedCache = [];
    protected array $lastWeightCache = [];
    protected array $lastWeightingCache = [];
    protected array $nextWeightCache = [];
    protected array $timeToWeightCache = [];

    public function all()
    {
        return Animal::all();
    }

    public function getAllInBreeding()
    {
        return Animal::where(function ($query) {
            $query->where('animal_category_id', '=', 1)
            ->orWhere('animal_category_id', '=', 4);
        })->orderBy('id', 'desc')->get();
    }

    public function getAllInBreedingMales()
    {
        return Animal::where(function ($query) {
            $query->where('animal_category_id', '=', 1)
            ->orWhere('animal_category_id', '=', 4);
        })->where('sex', 2)
        ->orderBy('id')->get();
    }

    public function getAllInBreedingFemales()
    {
        return Animal::where(function ($query) {
            $query->where('animal_category_id', '=', 1)
            ->orWhere('animal_category_id', '=', 4);
        })->where('sex', 3)
        ->orderBy('id')->get();
    }
    public function getAllUnsoldAnimals()
    {
        return Animal::where(function ($query) {
            $query->where('animal_category_id', '=', 1)
            ->orWhere('animal_category_id', '=', 2)
            ->orWhere('animal_category_id', '=', 4);
        })->orderBy('id')->get();
    }

    public function getAllByCategory(int $category){
        return Animal::where('animal_category_id', $category)->orderBy('id')->get();
    }

    public function getById(int $id)
    {
        return Animal::findOrFail($id);
    }

    public function getByToken(string $token)
    {
        return Animal::where('public_profile_tag', $token)->first();
    }

    public function getByLitter(int $litterId)
    {
        return Animal::where('litter_id', $litterId)->get();
    }

    public function getUnsoldOffer()
    {
        return AnimalOffer::where('sold_date', null)->get();
    }

    public function sexName(int $value): string
        {
            return [
                0 => 'N/sex',
                1 => 'N/sex',
                2 => '♂ Samiec',
                3 => '♀ Samica',
            ][$value] ?? 'b/d';
        }

    public function feedInterval(int $animalId): int
    {
        if (array_key_exists($animalId, $this->feedIntervalCache)) {
            return $this->feedIntervalCache[$animalId];
        }

        $animal = Animal::find($animalId);
        if (!is_null($animal->feed_id)) {
            if (is_null($animal->feed_interval)) {
                $feed = Feed::find($animal->feed_id);

                return $this->feedIntervalCache[$animalId] = $feed->feeding_interval;
            } else {
                return $this->feedIntervalCache[$animalId] = $animal->feed_interval;
            }
        }

        return $this->feedIntervalCache[$animalId] = 0;
    }

    public function lastFeed(int $animalId): string
    {
        if (array_key_exists($animalId, $this->lastFeedCache)) {
            return $this->lastFeedCache[$animalId];
        }

        $feed = AnimalFeedings::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
        if ($feed) {
            return $this->lastFeedCache[$animalId] = $feed->created_at->format('Y-m-d');
        }

        return $this->lastFeedCache[$animalId] = '';
    }

    public function nextFeed(int $animalId): string
    {
        if (array_key_exists($animalId, $this->nextFeedCache)) {
            return $this->nextFeedCache[$animalId];
        }

        if ($this->lastFeed($animalId)) {
            $date = Carbon::parse($this->lastFeed($animalId));

            return $this->nextFeedCache[$animalId] = $date->addDays($this->feedInterval($animalId))->format('Y-m-d');
        }

        return $this->nextFeedCache[$animalId] = '';
    }

    public function timeToFeed(int $animalId)
    {
        if (array_key_exists($animalId, $this->timeToFeedCache)) {
            return $this->timeToFeedCache[$animalId];
        }

        $nowDate = Carbon::now();

        $nextFeedDate = $this->nextFeed($animalId);
        $test = Carbon::parse($nextFeedDate);
        $diff = Carbon::parse($nowDate)->diffInDays($test, false);
        $diff = ($diff < 0) ? $diff - 1 : $diff;
        $diff = ($nowDate->format('Y-m-d') == $test->format('Y-m-d')) ? $diff : $diff + 1;

        return $this->timeToFeedCache[$animalId] = $diff;
    }

    public function feedCount(int $animalId): int
    {
        $animal = AnimalFeedings::where('animal_id', $animalId)->where('feed_id', '<>', 0)->count();

        return $animal;
    }

    public function lastWeight(int $animalId): int|null
    {
        if (array_key_exists($animalId, $this->lastWeightCache)) {
            return $this->lastWeightCache[$animalId];
        }

        $weight = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();

        return $this->lastWeightCache[$animalId] = $weight->value ?? null;
    }

    public function lastWeighting(int $animalId): string
    {
        if (array_key_exists($animalId, $this->lastWeightingCache)) {
            return $this->lastWeightingCache[$animalId];
        }

        $feed = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
        if ($feed) {
            return $this->lastWeightingCache[$animalId] = $feed->created_at->format('Y-m-d');
        }

        return $this->lastWeightingCache[$animalId] = '';
    }

    public function nextWeight(int $animalId): string
    {
        if (array_key_exists($animalId, $this->nextWeightCache)) {
            return $this->nextWeightCache[$animalId];
        }

        if ($this->lastWeight($animalId)) {
            $date = Carbon::parse($this->lastWeighting($animalId));

            return $this->nextWeightCache[$animalId] = $date->addDays(30)->format('Y-m-d');
        }

        return $this->nextWeightCache[$animalId] = '';
    }

    public function timeToWeight(int $animalId)
    {
        if (array_key_exists($animalId, $this->timeToWeightCache)) {
            return $this->timeToWeightCache[$animalId];
        }

        $nowDate = Carbon::now();
        $nextWeight = $this->nextWeight($animalId);
        $nextWeightDate = Carbon::parse($nextWeight);
        $diff = Carbon::parse($nowDate)->diffInDays($nextWeightDate, false);
        $diff = ($nowDate->format('Y-m-d') == $nextWeightDate->format('Y-m-d')) ? $diff : $diff + 1;
        $diff = ($diff < 0) ? $diff - 1 : $diff;

        return $this->timeToWeightCache[$animalId] = $diff;
    }

    public function animalStatus(int $animalId)
    {
        $animal = Animal::find($animalId);
        $offerCount = AnimalOffer::where('animal_id', $animalId)->count();
        if ($animal->animal_category_id != 2) {
            return $animal->animalCategory?->name;
        }

        if ($this->feedCount($animalId) < 3) {
            return 'W trakcie wykarmiania';
        } elseif ($offerCount == 1) {
            return 'Wystawiony na sprzedaż';
        } else {
            return 'Wykarmiony - oczekiwanie na sprzedaż';
        }
    }

    public function getByIdsWithRelations(array $ids) {
        return Animal::with(['animalType','animalCategory'])->whereIn('id', $ids)->orderBy('id')->get();
    }
}
