<?php

namespace App\Livewire\Settings;

use App\Models\WinteringStages;
use Livewire\Component;

class SettingsAnimalWitering extends Component
{
    public $stagesEditId;
    public $title;
    public $order;
    public $duration;
    public $newTitle;
    public $newOrder;
    public $newDuration;

    public function render()
    {
        return view('livewire.settings.settings-animal-witering', [
            'winteringsStages' => WinteringStages::orderBy('order', 'asc')->get(),
        ]);
    }

    public function editShow(int $id)
    {
        $this->stagesEditId == '';
        $stagesEdit = WinteringStages::find($id);
        $this->stagesEditId = $stagesEdit->id;
        $this->order = $stagesEdit->order;
        $this->title = $stagesEdit->title;
        $this->duration = $stagesEdit->duration;
    }

    public function editSave()
    {
        $stage = WinteringStages::find($this->stagesEditId);
        $stage->order = $this->order;
        $stage->title = $this->title;
        $stage->duration = $this->duration;
        $stage->save();
        $this->reset();
        $this->stagesEditId = '';
    }

    public function create()
    {
        $lastOrder = WinteringStages::max('order');
        $orderCheck = WinteringStages::where('order', $this->newOrder);

        if ($orderCheck->count() != 0) {
            $this->newOrder = $lastOrder + 1;
        }
        $stage = new WinteringStages();
        $stage->order = $this->newOrder;
        $stage->title = $this->newTitle;
        $stage->duration = $this->newDuration;
        $stage->save();
        $this->reset();
    }

    public function delete()
    {
        $stage = WinteringStages::find($this->stagesEditId)->delete();
    }
}
