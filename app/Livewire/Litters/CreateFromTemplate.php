<?php

namespace App\Livewire\Litters;

use App\Models\Animal;
use App\Models\Litter;
use App\Models\LittersPairing;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateFromTemplate extends Component
{
    public $female, $male, $litterId;
    public $stepOne, $stepTwo, $stepThree;

    #[On('render')]
    public function render()
    {
        return view('livewire.litters.create-from-template', [
            'females' => Animal::where('sex', 3)->where('animal_category_id', '!=', 2)->where('animal_category_id', '!=', 3)->where('animal_category_id', '!=', 5)->get(),
            'males' => Animal::where('sex', 2)->where('animal_category_id', '!=', 2)->where('animal_category_id', '!=', 3)->where('animal_category_id', '!=', 5)->get(),
            'list' => $this->list(),
        ]);
    }

    public function list()
    {
        if ($this->male != '' and $this->female != '') {
            $litter = Litter::where('parent_male', $this->male)->where('parent_female', $this->female)->where('category', 3)->get();
            return $litter;
        }
    }
    public function createLitter()
    {
        $template = Litter::find($this->litterId);

        $litter = new Litter;
        $litter->category = 2;
        $litter->litter_code = "PLAN";
        $litter->parent_male = $template->parent_male;
        $litter->parent_female = $template->parent_female;
        $litter->save();

        $littersPairings = LittersPairing::where('litter_id', $template->id)->get();
        foreach ($littersPairings as $lP) {
            $newPairing = new LittersPairing;
            $newPairing->percent = $lP->percent;
            $newPairing->title_vis = $lP->title_vis;
            $newPairing->title_het = $lP->title_het;
            $newPairing->litter_id = $litter->id;
            $newPairing->img_url = $lP->img_url;
            $newPairing->save();
        }

        return redirect(route('litters.index'));
    }
}
