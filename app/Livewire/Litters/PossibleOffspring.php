<?php

namespace App\Livewire\Litters;

use App\Models\AnimalGenotypeCategory;
use App\Models\Litter;
use App\Models\LittersPairing;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PossibleOffspring extends Component
{
    public $filterVis = [], $filterHet = [], $filterCategory = [], $filterSeason = [], $posscheck, $visHelper;


    public function render()
    {
        return view('livewire.litters.possible-offspring', [
            'offspring' => $this->filters(),
            'genCategory' => AnimalGenotypeCategory::all(),
            'seasons' => Litter::orderBy('season', 'desc')->get()->groupBy('season'),
        ]);
    }

    public function filters()
    {
        $query = LittersPairing::query();

        if (!in_array('all', $this->filterHet)) {
            foreach ($this->filterHet ?? [] as $het) {
                $query->where(function ($q) use ($het) {
                    $q->where('title_het', 'LIKE', '% ' . $het . '%');
                    $q->orWhere('title_het', 'LIKE', '' . $het . '%');
                });
            }
        }
        if (!in_array('all', $this->filterVis)) {
            foreach ($this->filterVis ?? [] as $vis) {
                $query->where(function ($q) use ($vis) {
                    $q->where('title_vis', 'LIKE', '% ' . $vis . '%');
                    $q->orWhere('title_vis', 'LIKE', $vis . '%');
                });
            }
        }
        if (!in_array('all', $this->filterSeason) and !empty($this->filterSeason)) {
            $query->where(function ($q) {
                foreach ($this->filterSeason ?? [] as $season) {
                    $q->orWhereRelation('litterDetails', 'season',  '=', $season);
                }
            });
        }
        if (!in_array('all', $this->filterCategory) and !empty($this->filterCategory)) {
            $query->where(function ($q) {
                foreach ($this->filterCategory ?? [] as $cat) {
                    $q->orWhereRelation('litterDetails', 'category',  '=', $cat);
                }
            });
        }
        if (!empty($this->visHelper)) {
            $visHelper = $this->visHelper;
            $query->where(function ($q) use ($visHelper) {
                $q->where('title_vis', 'LIKE', '%(' . $visHelper . '%');
            });
        }
        if (!empty($this->posscheck == true) and $this->posscheck == true) {
            $possC = ($this->posscheck == true) ? "PossCheck" : '';
            $query->where(function ($q) use ($possC) {
                $q->whereRelation('litterDetails', 'litter_code', 'LIKE', '% ' . $possC . '%');
                $q->orWhereRelation('litterDetails', 'litter_code', 'LIKE', $possC . '%');
            });
        } else {
            $possC = ($this->posscheck == false) ? "PossCheck" : '';
            $query->where(function ($q) use ($possC) {
                $q->whereRelation('litterDetails', 'litter_code', 'NOT LIKE', '%' . $possC . '%');
                // $q->orWhereRelation('litterDetails', 'litter_code', 'NOT LIKE', $possC . '%');
            });
        }


        $ltPaitings = $query->distinct()->orderBy('title_vis')->get();
        return $ltPaitings;
    }
}
