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

    public function getById(int $id)
    {
        return Animal::findOrFail($id);
    }

    public function getByLitter(int $litterId)
    {
        return Animal::where('litter_id', $litterId)->get();
    }

    public function sexName(int $value): string
    {
        switch ($value) {
            case 1:
                return 'N/sex';
                break;
            case 2:
                return '♂ Samiec';
                break;
            case 3:
                return '♀ Samica';
                break;
        }
    }

    public function feedInterval(int $animalId): int
    {
        $animal = Animal::find($animalId);
        if (!is_null($animal->feed_id)) {
            if (is_null($animal->feed_interval)) {
                $feed = Feed::find($animal->feed_id);

                return $feed->feeding_interval;
            } else {
                return $animal->feed_interval;
            }
        }

        return 0;
    }

    public function lastFeed(int $animalId): string
    {
        $feed = AnimalFeedings::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
        if ($feed) {
            return $feed->created_at->format('Y-m-d');
        } else {
            return '';
        }
    }

    public function nextFeed(int $animalId): string
    {
        if ($this->lastFeed($animalId)) {
            $date = Carbon::parse($this->lastFeed($animalId));

            return $date->addDays($this->feedInterval($animalId))->format('Y-m-d');
        } else {
            return '';
        }
    }

    public function timeToFeed(int $animalId)
    {
        $nowDate = Carbon::now();

        $nextFeedDate = $this->nextFeed($animalId);
        $test = Carbon::parse($nextFeedDate);
        $diff = Carbon::parse($nowDate)->diffInDays($test, false);
        $diff = ($diff < 0) ? $diff - 1 : $diff;
        $diff = ($nowDate->format('Y-m-d') == $test->format('Y-m-d')) ? $diff : $diff + 1;

        return $diff;
    }

    public function feedCount(int $animalId): int
    {
        $animal = AnimalFeedings::where('animal_id', $animalId)->where('feed_id', '<>', 0)->count();

        return $animal;
    }

    public function lastWeight(int $animalId): int|null
    {
        $weight = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();

        return $weight->value ?? null;
    }

    public function lastWeighting(int $animalId): string
    {
        $feed = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
        if ($feed) {
            return $feed->created_at->format('Y-m-d');
        } else {
            return '';
        }
    }

    public function nextWeight(int $animalId): string
    {
        if ($this->lastWeight($animalId)) {
            $date = Carbon::parse($this->lastWeighting($animalId));

            return $date->addDays(30)->format('Y-m-d');
        } else {
            return '';
        }
    }

    public function timeToWeight(int $animalId)
    {
        $nowDate = Carbon::now();
        $nextWeight = $this->nextWeight($animalId);
        $nextWeightDate = Carbon::parse($nextWeight);
        $diff = Carbon::parse($nowDate)->diffInDays($nextWeightDate, false);
        $diff = ($nowDate->format('Y-m-d') == $nextWeightDate->format('Y-m-d')) ? $diff : $diff + 1;
        $diff = ($diff < 0) ? $diff - 1 : $diff;

        return $diff;
    }

    public function animalStatus(int $animalId)
    {
        $animal = Animal::find($animalId);
        $offerCount = AnimalOffer::where('animal_id', $animalId)->count();
        if ($animal->animal_category_id != 2) {
            return $animal->animalCategory?->name;
        }

        if ($this->feedCount($animalId) < 4) {
            return 'W trakcie wykarmiania';
        } elseif ($offerCount == 1) {
            return 'Wystawiony na sprzedaż';
        } else {
            return 'Wykarmiony - oczekiwanie na sprzedaż';
        }
    }
}
