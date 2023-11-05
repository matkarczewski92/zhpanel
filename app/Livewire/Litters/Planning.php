<?php

namespace App\Livewire\Litters;

use Carbon\Carbon;
use Livewire\Component;

class Planning extends Component
{
    public $connectionDate, $layingDate, $hatchlingDate;
    public function render()
    {
        return view('livewire.litters.planning');
    }

    public function change(string $type): void
    {
        $layingDuration = systemConfig('layingDuration');
        $hatchlingDuration = systemConfig('hatchlingDuration');

        if ($type == 'c') {
            $cD = Carbon::parse($this->connectionDate);
            $lD = $cD->addDays($layingDuration);
            $this->layingDate = $lD->format("Y-m-d");
            $hD = $lD->addDays($hatchlingDuration);
            $this->hatchlingDate = $hD->format("Y-m-d");
        } else  if ($type == 'l') {
            $lD = Carbon::parse($this->layingDate);
            $cD = $lD->subDays($layingDuration);
            $this->connectionDate = $cD->format("Y-m-d");
            $lD = Carbon::parse($this->layingDate);
            $hD = $lD->addDays($hatchlingDuration);
            $this->hatchlingDate = $hD->format("Y-m-d");
        } else if ($type == 'h') {
            $hD = Carbon::parse($this->hatchlingDate);
            $lD = $hD->subDays($hatchlingDuration);
            $this->layingDate = $lD->format("Y-m-d");
            $cD = $hD->subDays($layingDuration);
            $this->connectionDate = $cD->format("Y-m-d");
        }
    }
}
