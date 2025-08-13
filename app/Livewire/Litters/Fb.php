<?php

namespace App\Livewire\Litters;

use App\Models\Animal;
use App\Models\Litter;
use App\Services\FacebookService;
use Livewire\Component;

class Fb extends Component
{
    public int|string $litterId;
    public string $adnotation = '';
    public string $status = '';

    // USTAW startowe dane TYLKO raz
    public function mount($litterId): void
    {
        $this->adnotation = $this->prepare_message(Litter::find($litterId));
    }

    public function render()
    {
        $litter = Litter::find($this->litterId);

        return view('livewire.litters.fb', [
            'litter' => $litter,
        ]);
    }

    public function save()
    {
        $message = (string) $this->adnotation; // bez zamiany na \\n

        $litter = Litter::find($this->litterId);
        $urlsString = (string) $this->createUrls($litter);

        $urlsString = preg_replace('/,\s*$/', '', $urlsString);
        $urlsArray = array_values(array_filter(
            array_map('trim', explode(',', $urlsString)),
            fn ($u) => $u !== '' && (str_starts_with($u, 'http://') || str_starts_with($u, 'https://'))
        ));

        try {
            @set_time_limit(120);
            app(\App\Services\FacebookService::class)
                ->postMultipleImages($message, $urlsArray);

            return redirect(url()->previous() . '?OK');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function createUrls(Litter $litter)
        {
            $animalUrls = '';
            $animals = Animal::where('litter_id', $litter->id)->get();
            foreach($animals as $animal) {
                $animalUrls .= 'https://www.makssnake.pl'.$animal->animalMainPhoto->url.',';
            }
            return $animalUrls;
    }

    public function prepare_message(Litter $litter): string
        {
            $litter_code = $litter->litter_code;
            $hatch_date = $litter->hatching_date ?? '';
            $parent_male = strip_tags($litter->animalMale->name);
            $parent_female = strip_tags($litter->animalFemale->name);
            
            $litter_code   = $litter->litter_code;
            $hatch_date    = $litter->hatching_date ?? '';
            $parent_male   = strip_tags(optional($litter->animalMale)->name);
            $parent_female = strip_tags(optional($litter->animalFemale)->name);

            return "Miot: $litter_code\nData klucia: $hatch_date\nRodzice:\n$parent_male\nx\n$parent_female\n\nhttps://www.makssnake.pl";
        }

}