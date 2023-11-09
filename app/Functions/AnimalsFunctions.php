<?php


use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalOffer;
use App\Models\AnimalWeight;
use App\Models\Feed;
use Carbon\Carbon;

function sexName(int $value): String
{
    switch ($value) {
        case 1:
            return "N/sex";
            break;
        case 2:
            return "Samiec";
            break;
        case 3:
            return "Samica";
            break;
    }
}
function feedInterval(int $animalId): int
{
    $animal = Animal::find($animalId);
    if (!is_null($animal->feed_id)) {
        if (is_null($animal->feed_interval)) {
            $feed = Feed::find($animal->feed_id);
            return $feed->feeding_interval;
        } else return $animal->feed_interval;
    }
    return 0;
}
function lastFeed(int $animalId): String
{
    $feed = AnimalFeedings::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
    if ($feed) {
        return $feed->created_at->format('Y-m-d');
    } else return "";
}

function nextFeed(int $animalId): String
{
    if (lastFeed($animalId)) {
        $date = Carbon::parse(lastFeed($animalId));
        return $date->addDays(feedInterval($animalId))->format('Y-m-d');
    } else return "";
}

function timeToFeed(int $animalId)
{
    $nowDate = Carbon::now();

    $nextFeedDate = nextFeed($animalId);
    $test = Carbon::parse($nextFeedDate);
    $diff = Carbon::parse($nowDate)->diffInDays($test, false);
    $diff = ($diff < 0) ? $diff - 1 : $diff;
    $diff = ($nowDate->format("Y-m-d") == $test->format("Y-m-d")) ? $diff : $diff + 1;
    return $diff;
}

function feedCount(int $animalId): int
{
    $animal = AnimalFeedings::where('animal_id', $animalId)->where('feed_id', '<>', 0)->count();
    return $animal;
}



function lastWeight(int $animalId): int|null
{
    $weight = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
    return $weight->value ?? null;
}
function lastWeighting(int $animalId): String
{
    $feed = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->first();
    if ($feed) {
        return $feed->created_at->format('Y-m-d');
    } else return "";
}
function nextWeight(int $animalId): String
{
    if (lastWeight($animalId)) {
        $date = Carbon::parse(lastWeighting($animalId));
        return $date->addDays(30)->format('Y-m-d');
    } else return "";
}
function timeToWeight(int $animalId)
{
    $nowDate = Carbon::now();
    $nextWeight = nextWeight($animalId);
    $nextWeightDate = Carbon::parse($nextWeight);
    $diff = Carbon::parse($nowDate)->diffInDays($nextWeightDate, false);
    $diff = ($nowDate->format("Y-m-d") == $nextWeightDate->format("Y-m-d")) ? $diff : $diff + 1;
    $diff = ($diff < 0) ? $diff - 1 : $diff;
    return $diff;
}


function animalStatus(int $animalId)
{
    $animal = Animal::find($animalId);
    $offerCount = AnimalOffer::where('animal_id', $animalId)->count();
    if ($animal->animal_category_id != 2) {
        return $animal->animalCategory->name;
    }
    if (feedCount($animalId) < 4) {
        return "W trakcie wykarmiania";
    } else if ($offerCount == 1) {
        return "Wystawiony na sprzedaż";
    } else return "Wykarmiony - oczekiwanie na sprzedaż";
}
