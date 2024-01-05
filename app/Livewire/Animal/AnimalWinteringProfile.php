<?php

namespace App\Livewire\Animal;

use App\Models\Wintering;
use App\Models\WinteringStages;
use Livewire\Component;

class AnimalWinteringProfile extends Component
{
    public $animalId = '';
    public $editMode = 0;
    public $editStartDate;
    public $editEndDate;
    public $editPlannedStart;
    public $editPlannedEnd;
    public $editCustomDuration;
    public $editModeStageId = 0;
    public $editBtnMode = 'success';

    public function render()
    {
        return view('livewire.animal.animal-wintering-profile', [
            'winterings' => Wintering::where('animal_id', $this->animalId)->where('archive', null)->get(),
        ]);
    }

    public function editModeSwitch()
    {
        if ($this->editMode == 0) {
            $this->editMode = 1;
            $this->editBtnMode = 'danger';
        } else {
            $this->editMode = 0;
            $this->editBtnMode = 'success';
        }
    }

    public function editModeStage($id)
    {
        $stageDetails = Wintering::findOrFail($id);
        $this->editModeStageId = ($this->editModeStageId == $id) ? 0 : $id;
        $this->editStartDate = $stageDetails->start_date ?? '';
        $this->editEndDate = $stageDetails->end_date ?? '';
        $this->editCustomDuration = $stageDetails->custom_duration ?? '';
    }

    public function editStage()
    {
        $stage = Wintering::findOrFail($this->editModeStageId);
        $stageDetails = WinteringStages::find($stage->stage_id);
        $stage->start_date = (!empty($this->editStartDate)) ? $this->editStartDate : null;
        $stage->end_date = (!empty($this->editEndDate)) ? $this->editEndDate : null;
        $stage->custom_duration = (!empty($this->editCustomDuration)) ? $this->editCustomDuration : null;
        $stage->save();
        $this->updateDates($stage->animal_id);
        $this->editModeStageId = 0;
    }

    public function stageDelete(int $id)
    {
        $delete = Wintering::find($id)->delete();
    }

    public function startStage(int $stagideId)
    {
        $date = date('Y-m-d');
        $stage = Wintering::findOrFail($stagideId);
        $stage->start_date = $date;
        $stage->save();
        $this->updateDates($stage->animal_id);
    }

    public function endStage(int $stagideId)
    {
        $date = date('Y-m-d');
        $stage = Wintering::findOrFail($stagideId);
        $stage->end_date = $date;
        $stage->save();
        $this->updateDates($stage->animal_id);
    }

    public function deleteWintering(int $animalId)
    {
        $wintering = Wintering::where('animal_id', $animalId)->where('archive', null)->delete();
    }

    public function closeWintering(int $animalId)
    {
        $wintering = Wintering::where('animal_id', $animalId)->where('archive', null)->update(['archive' => '1']);
    }

    public function openWintering(int $animalId)
    {
        $year = date('Y');
        $stages = WinteringStages::orderBy('order', 'asc')->get();
        foreach ($stages as $st) {
            $wSt = new Wintering();
            $wSt->animal_id = $animalId;
            $wSt->season = $year;
            $wSt->stage_id = $st->id;
            $wSt->save();
        }
    }

    public function updateDates(int $animalId)
    {
        $wCount = Wintering::where('animal_id', $animalId)
        ->where('archive', null)
        ->where('start_date', '!=', null)
        ->count();
        if ($wCount != 0) {
            $winterings = Wintering::where('animal_id', $animalId)
            ->where('archive', null)
            ->where('start_date', '!=', null)
            ->orderBy('id', 'desc')
            ->first();
            $duration = $winterings->custom_duration ?? $winterings->stageDetails->duration;
            $winterings->planned_end_date = date('Y-m-d', strtotime($winterings->start_date.' + '.$duration.' days'));
            $winterings->save();

            $stages = Wintering::join('winterings_stage', 'winterings.stage_id', '=', 'winterings_stage.id')->where('animal_id', $animalId)->where('archive', null)->where('order', '>', $winterings->stageDetails->order)->orderBy('order')->get();

            foreach ($stages as $st) {
                $prevStages = WinteringStages::join('winterings', 'winterings_stage.id', '=', 'winterings.stage_id')->where('animal_id', $animalId)->where('order', '<', $st->order)->orderBy('order', 'desc')->first();
                $wintering = Wintering::where('animal_id', $animalId)->where('archive', null)->where('stage_id', '=', $st->stage_id)->first();
                $duration = $wintering->custom_duration ?? $st->duration;

                $wintering->planned_start_date = $prevStages->end_date ?? $prevStages->planned_end_date;
                $wintering->planned_end_date = date('Y-m-d', strtotime($wintering->planned_start_date.' + '.$duration.' days'));
                $wintering->save();
            }
        }
    }
}
