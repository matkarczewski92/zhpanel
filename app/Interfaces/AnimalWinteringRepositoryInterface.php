<?php

namespace App\Interfaces;

interface AnimalWinteringRepositoryInterface
{
    public function getDurationsToEndByOrder(int $order);

    public function winteringStart(int $animalId);

    public function winteringEnd(int $animalId);

    public function winteringActualStage(int $animalId);

    public function getWinteringStageDetails(int $animalId, $order);
}
