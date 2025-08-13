<?php

namespace App\Livewire\Litters;

use App\Models\Animal;
use App\Models\Litter;
use App\Models\LitterAdnotations;
use App\Services\FacebookService;
use Livewire\Component;

class Fb extends Component
{
    public $litterId, $adnotation, $status = '';

    public function render()
    {
        $litter = Litter::find($this->litterId);
        $urls = $this->createUrls($litter);
        $this->adnotation = $this->prepare_message($litter);

        return view('livewire.litters.fb', [
            'litter' => $litter,
        ]);
    }

    public function save()
    {
        $message = $this->prepareFacebookMessage($this->adnotation);

        // Zamień string URL-i w tablicę
        $urls = $this->createUrls(Litter::find($this->litterId));
        if (is_string($urls)) {
            $urls = array_filter(array_map('trim', explode(',', $urls)));
        }

        try {
            /** @var FacebookService $fb */
            $fb = app(FacebookService::class);

            if (empty($urls)) {
                // post tekstowy
                $fb->postText($message);
            } elseif (count($urls) === 1) {
                // jedno zdjęcie
                $fb->postImage($message, $urls[0]);
            } else {
                // wiele zdjęć
                $fb->postMultipleImages($message, $urls);
            }

            // przekierowanie z dopisanym ?OK
            return redirect(url()->previous() . '?OK');

        } catch (\Throwable $e) {
            // błąd: zwróć JSON
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

    public function prepare_message(Litter $litter)
    {
        $litter_code = $litter->litter_code;
        $hatch_date = $litter->hatching_date ?? '';
        $parent_male = strip_tags($litter->animalMale->name);
        $parent_female = strip_tags($litter->animalFemale->name);
        
        return "Miot: $litter_code\nData klucia: $hatch_date\nRodzice:\n$parent_male\nx\n$parent_female";
    }
    function prepareFacebookMessage($text)
    {
        // Usuń HTML
        $clean = strip_tags($text);

        // Zamień wszystkie wielokrotne spacje lub entery na dosłowny \n
        $clean = preg_replace('/\s+/', '\\n', $clean);

        // Usuń zbędne \n z początku i końca
        $clean = trim($clean, "\\n");

        return $clean;
    }


}
