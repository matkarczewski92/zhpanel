<?php

namespace App\Http\Controllers;

use App\Models\Litter;
use Illuminate\Support\Facades\DB;

class LittersPlanningController extends Controller
{
    public $year;

    public function index()
    {
        $this->year = date('Y');

        return view('llitters-planning', [
            'connectionArray' => $this->getConnectionArray($_GET['filter'] ?? null),
            'getLayingArray' => $this->getLayingArray($_GET['filter'] ?? null),
            'getHatchlingArray' => $this->getHatchlingArray($_GET['filter'] ?? null),
        ]);
    }

    public function getConnectionArray(int $id = null): array
    {
        $array = [];
        $filter = (is_null($id)) ? ['id', '!=',  $id] : ['id', $id];
        for ($i = 1; $i <= 12; ++$i) {
            $litters = Litter::whereMonth(DB::raw('IFNULL(connection_date, planned_connection_date)'), $i)
            ->where([$filter])
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

    public function getLayingArray(int $id = null): array
    {
        $array = [];
        $filter = (is_null($id)) ? ['id', '!=',  $id] : ['id', $id];
        $litters = Litter::where(function ($query) {
            $query->whereMonth(DB::raw('IFNULL(connection_date, planned_connection_date)'), '<>', null);
        })
        ->where([$filter])
        ->where('season', $this->year)
        ->orderByRaw('CASE WHEN connection_date IS NULL THEN planned_connection_date ELSE connection_date END')
        ->get();
        // dump($litters);
        foreach ($litters ?? [] as $lt) {
            $dateL = $lt->connection_date ?? $lt->planned_connection_date;
            $layingday = date('m', strtotime($dateL.' + '.systemConfig('layingDuration').' day'));
            $array[(int) $layingday][] = $lt;
        }

        return $array;
    }

    public function getHatchlingArray(int $id = null): array
    {
        $array = [];
        $filter = (is_null($id)) ? ['id', '!=',  $id] : ['id', $id];
        $litters = Litter::where(function ($query) {
            $query->whereMonth(DB::raw('IFNULL(connection_date, planned_connection_date)'), '<>', null);
        })
        ->where([$filter])
        ->where('season', $this->year)
        ->orderByRaw('CASE WHEN connection_date IS NULL THEN planned_connection_date ELSE connection_date END')
        ->get();
        // dump($litters);
        foreach ($litters ?? [] as $lt) {
            $dateH = $lt->connection_date ?? $lt->planned_connection_date;
            $hatchlingday = date('m', strtotime($dateH.' + '.systemConfig('layingDuration') + systemConfig('hatchlingDuration').' day'));
            $array[(int) $hatchlingday][] = $lt;
        }

        return $array;
    }
}
