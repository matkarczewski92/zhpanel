<?php

namespace App\Livewire\Animal;

use App\Charts\AnimalWeightChart;
use App\Models\AnimalWeight as ModelsAnimalWeight;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class AnimalWeight extends Component
{


    protected $listeners = ['refreshComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    use WithPagination;
    public $animalId = "";
    public $inputWeight = "";
    public $inputDate = "";

    public function render()
    {
        $this->inputDate = Carbon::now()->format("Y-m-d");
        return view('livewire.animal.animal-weight', [
            'weightHistory' => ModelsAnimalWeight::where('animal_id', '=', $this->animalId)->orderBy('created_at', 'desc')->paginate(5, ['*'], 'weightPage'),
            'charts' => $this->weightChart($this->animalId),
        ]);
    }
    public function delete(int $id)
    {
        $feed = ModelsAnimalWeight::find($id);
        if (!empty($feed->id)) $feed->delete($id);
        return redirect(request()->header('Referer'));
    }
    public function weightChart(int $animalId)
    {
        $chartData = ModelsAnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->latest()->take(10)->get()->reverse();
        $chart = new AnimalWeightChart;
        foreach ($chartData as $group) {
            $dateCreate = date_create($group->created_at);
            $label[] = date_format($dateCreate, "Y-m-d");
            $data[] = $group->value;
        }
        if (!empty($label)) {
            $chart->labels($label);
            $chart->dataset('Waga', 'line', $data)->options([
                'backgroundColor' => 'rgba(81, 153, 255, 0.9)',
            ]);
        } else {
            $chart->labels([0]);
            $chart->dataset('Waga', 'line', [0])->options([
                'backgroundColor' => 'rgba(81, 153, 255, 0.9)',
            ]);
        }
        return $chart;
    }
    public function addWeight()
    {
        if ($this->inputDate == "") $date = Carbon::now()->format("Y-m-d");
        else $date = $this->inputDate;
        $weight = new ModelsAnimalWeight();
        $weight->animal_id = $this->animalId;
        $weight->created_at = $date;
        $weight->value = $this->inputWeight;
        $weight->save();
        return redirect(request()->header('Referer'));
    }
}
