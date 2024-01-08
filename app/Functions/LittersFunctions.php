<?php

use App\Models\Litter;
use App\Models\LittersPairing;
use App\Models\NotForSale;

function litterStatus(int $id): string
{
    $litter = Litter::find($id);

    if ($litter->hatching_date) {
        $return = 'W trakcie wykarmiania';
    }
    if (!$litter->hatching_date) {
        $return = 'W trakcie inkubacji';
    }
    if (!$litter->laying_date) {
        $return = 'Oczekiwanie na znios';
    }
    if (!$litter->connection_date) {
        $return = 'Oczekiwanie na łączenie';
    }
    if ($litter->category == 4) {
        $return = 'Zakończony';
    }

    return $return;
}
function litterCategory(int $category): string
{
    return match ($category) {
        1 => 'Miot',
        2 => 'Planowany',
        3 => 'Szablon miotu',
        4 => 'Zrealizowany',
    };
}

function litterOffspringPercentCount(int $litterId)
{
    $litterOffspring = LittersPairing::where('litter_id', $litterId)->sum('percent');

    return $litterOffspring;
}

function templateCount(int $femaleId, $maleId)
{
    $templateCount = Litter::where('parent_female', $femaleId)->where('parent_male', $maleId)->where('category', 2)->count();

    return $templateCount;
}

function checkNfs(int $paitngId)
{
    $nfs = NotForSale::where('pairing_id', $paitngId)->count();

    return $nfs ?? 0;
}
