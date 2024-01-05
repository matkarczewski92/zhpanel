<?php

namespace App\Http\Controllers;

use App\Models\Litter;

class LittersPlanningController extends Controller
{
    public $year;

    public function index()
    {
        $this->year = date('Y');

        return view('llitters-planning', [
            'connectionArray' => $this->getConnectionArray(),
            'getLayingArray' => $this->getLayingArray(),
            'getHatchlingArray' => $this->getHatchlingArray(),
        ]);
    }

    public function getConnectionArray(): array
    {
        $array = [];
        for ($i = 1; $i <= 12; ++$i) {
            $litters = Litter::whereMonth('planned_connection_date', $i)
            ->where('season', $this->year)
            ->where(function ($query) {
                $query->where('category', 1)->orWhere('category', 2);
            })
            ->get();
            // dump($litters);
            foreach ($litters ?? [] as $lt) {
                $array[(int) $i][] = $lt;
            }
        }

        return $array;
    }

    public function getLayingArray(): array
    {
        $array = [];

        $litters = Litter::whereMonth('planned_connection_date', '<>', null)->orderBy('planned_connection_date')->get();
        // dump($litters);
        foreach ($litters ?? [] as $lt) {
            $layingday = date('m', strtotime($lt->connection_date ?? $lt->planned_connection_date.' + '.systemConfig('layingDuration').' day'));
            $array[(int) $layingday][] = $lt;
        }

        return $array;
    }

    public function getHatchlingArray(): array
    {
        $array = [];

        $litters = Litter::whereMonth('planned_connection_date', '<>', null)->orderBy('planned_connection_date')->get();
        // dump($litters);
        foreach ($litters ?? [] as $lt) {
            $hatchlingday = date('m', strtotime($lt->connection_date ?? $lt->planned_connection_date.' + '.systemConfig('layingDuration') + systemConfig('hatchlingDuration').' day'));
            $array[(int) $hatchlingday][] = $lt;
        }

        return $array;
    }
}
