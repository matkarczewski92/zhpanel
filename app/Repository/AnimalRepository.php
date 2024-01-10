<?php

namespace App\Repository;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalFeedings;
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
        return Animal::where('animal_category_id', '=', 1)->orderBy('id', 'desc')->get();
    }

    public function getById(int $id)
    {
        return Animal::findOrFail($id);
    }

    public function lastWeight(int $animalId): int|null
    {
        $weight = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();

        return $weight->value ?? null;
    }

    public function sexName(int $value): string
    {
        switch ($value) {
            case 1:
                return 'N/sex';
                break;
            case 2:
                return 'Samiec';
                break;
            case 3:
                return 'Samica';
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
        if (lastFeed($animalId)) {
            $date = Carbon::parse(lastFeed($animalId));

            return $date->addDays(feedInterval($animalId))->format('Y-m-d');
        } else {
            return '';
        }
    }
}
