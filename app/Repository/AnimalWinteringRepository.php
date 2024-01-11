<?php

namespace App\Repository;

use App\Interfaces\AnimalWinteringRepositoryInterface;
use App\Models\Wintering;
use App\Models\WinteringStages;

class AnimalWinteringRepository implements AnimalWinteringRepositoryInterface
{
    public function getDurationsToEndByOrder(int $order)
    {
        $duration = WinteringStages::where('order', '>', $order)->sum('duration');

        return $duration;
    }

    public function winteringStart(int $animalId)
    {
        $wintering = WinteringStages::where('animal_id', $animalId)->where('archive', null)->first();

        return $wintering->start_date ?? '';
    }

    public function winteringEnd(int $animalId)
    {
        $wintering = Wintering::where('animal_id', $animalId)->where('archive', null)->orderBy('id', 'desc')->first();

        return $wintering->end_date ?? $wintering->planned_end_date ?? '';
    }

    public function winteringActualStage(int $animalId)
    {
        $wintering = Wintering::where('animal_id', $animalId)->where('archive', null)->where('start_date', '<>', null)->orderBy('id', 'desc')->first();
        $return['stage'] = $wintering->stageDetails->order;
        $return['title'] = $wintering->stageDetails->title;

        return $return;
    }

    public function getWinteringStageDetails(int $animalId, $order)
    {
        $getStageByOrder = WinteringStages::where('order', $order)->first();
        $wintering = Wintering::where('animal_id', $animalId)->where('stage_id', $getStageByOrder->id)->where('archive', null)->first();

        return $wintering;
    }
}
