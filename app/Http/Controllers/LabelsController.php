<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalOfferRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LabelsController extends Controller
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepo,
        private AnimalOfferRepositoryInterface $offerRepo
    ) {}

    public function index()
    {
        return view('labels', [
            'animals' => $this->animalRepo->getAllUnsoldAnimals(),
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'animal'   => ['required','array','min:1'],
            'animal.*' => ['integer'],                       // teraz zadziała, bo value to ID
            'action'   => ['required','in:preview,export'],
        ]);

        // bez kombinowania z kluczami — po prostu wartości
        $ids = array_map('intval', $validated['animal']);

        // pobierz hurtowo, jeśli masz metodę; w innym razie fallback
        if (method_exists($this->animalRepo, 'getByIdsWithRelations')) {
            $models = $this->animalRepo->getByIdsWithRelations($ids); // ->with('animalType','animalCategory')
        } else {
            $models = collect($ids)->map(fn($id) => $this->animalRepo->getById($id));
        }

        $rows = $models->map(function ($a) {
            $dob  = $a->date_of_birth ? \Illuminate\Support\Carbon::parse($a->date_of_birth)->format('Y-m-d') : null;
            $code = $a->public_profile_tag ?: $a->id;

            return [
                'id'            => $a->id,
                'type'          => $a->animalType?->name,
                'name'          => $a->name,
                'sex'           => $a->sex,            // zostawiamy numer dla podglądu HTML
                'date_of_birth' => $dob,
                'code'          => $code,
                'qr_url'        => 'https://www.makssnake.pl/profile/'.$code,
            ];
        });


        if ($validated['action'] === 'export') {
            return $this->exportCsv($rows);                 // -> natychmiastowy download na Twój komputer
        }

        return view('labels.labels-generate', [
            'animals' => $rows,
            'repo'    => $this->animalRepo,
        ]);
    }


    private function exportCsv($rows): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename  = 'labels_'.now()->format('Ymd_His').'.csv';
        $header    = ['id','type','name','sex','date_of_birth','code','qr_url','price'];
        $delimiter = ';';

        $csv = fopen('php://temp', 'w+');
        fputcsv($csv, $header, $delimiter);

        foreach ($rows as $r) {
            // mapowanie płci (2=Samiec, 3=Samica; reszta N/sex)
            $sexLabel = match ((int)($r['sex'] ?? 0)) {
                2       => 'Samiec',
                3       => 'Samica',
                default => 'N/sex',
            };

            // „goły” tekst
            $name = $this->plainText((string)($r['name'] ?? ''));
            $type = $this->plainText((string)($r['type'] ?? ''));

            $code   = (string)($r['code'] ?? '');
            $qrLink = 'https://www.makssnake.pl/profile/'.rawurlencode($code);

            // jeśli używasz offerRepo – pamiętaj o wstrzyknięciu go w __construct
            $price = $this->offerRepo->getById($r['id'])?->price ?? '';

            fputcsv($csv, [
                $r['id'], $type, $name, $sexLabel, $r['date_of_birth'],
                $code, $qrLink, $price
            ], $delimiter);
        }

        rewind($csv);
        $contents = stream_get_contents($csv);
        fclose($csv);

        // BEZ BOM – P-touch poprawnie odczyta UTF-8
        return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($contents) {
            echo $contents;
        }, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function plainText(string $html): string
    {
        // usuń tagi, zdekoduj encje, zamień NBSP, zredukuj białe znaki
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xC2\xA0", ' ', $text);     // NBSP -> spacja
        $text = preg_replace('/\s+/u', ' ', $text);      // konsolidacja białych znaków
        return trim($text);
    }
}
