<?php

namespace App\Repository;

use App\Interfaces\LitterRepositoryInterface;
use App\Models\Litter;
use App\Models\LittersPairing;
use App\Models\NotForSale;

class LitterRepository implements LitterRepositoryInterface
{
    public function all()
    {
        return Litter::all();
    }

    public function getById(int $litterId)
    {
        return Litter::findOrFail($litterId);
    }

    public function getAvailable()
    {
        return Litter::where('category', 1)->orWhere('category', 4)->get();
    }

    public function getByParents(int $animalId)
    {
        return Litter::where('parent_male', '=', $animalId)->orWhere('parent_female', '=', $animalId)->get();
    }

    public function litterStatus(int $id): string
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

    public function litterCategory(int $category): string
    {
        return match ($category) {
            1 => 'Miot',
            2 => 'Planowany',
            3 => 'Szablon miotu',
            4 => 'Zrealizowany',
        };
    }

    public function litterOffspringPercentCount(int $litterId)
    {
        $litterOffspring = LittersPairing::where('litter_id', $litterId)->sum('percent');

        return $litterOffspring;
    }

    public function templateCount(int $femaleId, $maleId)
    {
        $templateCount = Litter::where('parent_female', $femaleId)->where('parent_male', $maleId)->where('category', 2)->count();

        return $templateCount;
    }

    public function checkNfs(int $paitngId)
    {
        $nfs = NotForSale::where('pairing_id', $paitngId)->count();

        return $nfs ?? 0;
    }
}
