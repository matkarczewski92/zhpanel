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
        $this->litterId = $litterId;
        if ($litter = Litter::find($this->litterId)) {
            $this->adnotation = $this->prepare_message($litter);
        }
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
        $litter = Litter::find($this->litterId);
        if (!$litter) {
            return response()->json(['error' => 'Brak miotu.'], 404);
        }

        $message = $this->prepareFacebookMessage($this->adnotation);

        // URL-e jako TABLICA
        $urls = $this->createUrls($litter); // <- zwraca array
        try {
            /** @var FacebookService $fb */
            $fb = app(FacebookService::class);

            if (empty($urls)) {
                $fb->postText($message);
            } elseif (count($urls) === 1) {
                $fb->postImage($message, $urls[0]);
            } else {
                $fb->postMultipleImages($message, $urls);
            }

            // LIVEWIRE v3:
            return $this->redirect(request()->url().'?OK', navigate: true);

            // Jeśli masz Livewire v2, użyj zamiast powyższego:
            // return redirect()->to(url()->current().'?OK');

        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Zwróć TABLICĘ absolutnych URL-i zdjęć (bez pustych).
     */
    public function createUrls(Litter $litter): array
    {
        $urls = [];

        $animals = Animal::where('litter_id', $litter->id)->get();
        foreach ($animals as $animal) {
            $photo = $animal->animalMainPhoto ?? null;
            if ($photo && !empty($photo->url)) {
                $urls[] = 'https://www.makssnake.pl' . $photo->url;
            }
        }

        return $urls;
    }

    public function prepare_message(Litter $litter): string
    {
        $litter_code   = $litter->litter_code;
        $hatch_date    = $litter->hatching_date ?? '';
        $parent_male   = strip_tags(optional($litter->animalMale)->name);
        $parent_female = strip_tags(optional($litter->animalFemale)->name);

        return "Miot: $litter_code\nData klucia: $hatch_date\nRodzice:\n$parent_male\nx\n$parent_female";
    }

    /**
     * Zwraca tekst z DOSŁOWNYMI \n (np. do logów/preview) – zgodnie z Twoją wcześniejszą prośbą.
     * Jeśli wolisz realne entery do FB, zamień '\\n' na "\n".
     */
    public function prepareFacebookMessage(string $text): string
    {
        $clean = strip_tags($text);
        $clean = preg_replace('/\r\n|\r|\n/', '\\n', $clean);  // zamień realne entery na dosłowne \n
        $clean = preg_replace('/[ \t]+/', ' ', $clean);        // znormalizuj spacje
        $clean = trim($clean, "\\n ");

        return $clean;
    }
}
