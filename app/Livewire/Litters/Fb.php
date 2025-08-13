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

    // Nowe pola do sterowania UI
    public bool $submitted = false;     // czy formularz został wysłany
    public bool $apiOk      = false;    // czy API się udało
    public array|null $apiPayload = null; // odpowiedź z API (jeśli sukces)
    public string|null $error = null;   // treść błędu

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

    public function save(): void
    {
        $this->resetFeedback();

        $litter = Litter::find($this->litterId);
        if (!$litter) {
            $this->error = 'Brak miotu.';
            $this->submitted = true;
            return;
        }

        $message = $this->prepareFacebookMessage($this->adnotation);
        $urls    = $this->createUrls($litter); // array

        try {
            /** @var FacebookService $fb */
            $fb = app(FacebookService::class);

            if (empty($urls)) {
                $resp = $fb->postText($message);
            } elseif (count($urls) === 1) {
                $resp = $fb->postImage($message, $urls[0]);
            } else {
                $resp = $fb->postMultipleImages($message, $urls);
            }

            $this->apiOk      = true;
            $this->apiPayload = is_array($resp) ? $resp : ['raw' => $resp];
        } catch (\Throwable $e) {
            $this->apiOk = false;
            $this->error = $e->getMessage();
        }

        // Przełącz na ekran „wynik”
        $this->submitted = true;
    }

    public function resetForm(): void
    {
        $this->submitted = false;
        $this->apiOk = false;
        $this->apiPayload = null;
        $this->error = null;

        // odśwież treść (opcjonalnie)
        if ($litter = Litter::find($this->litterId)) {
            $this->adnotation = $this->prepare_message($litter);
        }
    }

    /** ====================== pomocnicze ====================== */

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

    public function prepareFacebookMessage(string $text): string
    {
        // HTML → entery
        $text = preg_replace(['#<br\s*/?>#i', '#</p>#i'], "\n", $text);
        $text = preg_replace('#<p[^>]*>#i', '', $text);

        $clean = strip_tags($text);
        $clean = preg_replace('/\r\n|\r|\n/', "\n", $clean);
        $clean = preg_replace('/[ \t]+/', ' ', $clean);
        $clean = preg_replace("/\n{3,}/", "\n\n", $clean);

        return trim($clean);
    }

    private function resetFeedback(): void
    {
        $this->apiOk = false;
        $this->apiPayload = null;
        $this->error = null;
        $this->submitted = false;
    }
}
