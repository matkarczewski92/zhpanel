<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\Animal;
use App\Models\AnimalOffer;
use App\Models\Finances;
use App\Models\FinancesCategory;
use App\Models\Litter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    public function index(Request $request)
    {
        $animalsToFeed = $this->animalToFeed();
        $littersToFeed = $this->animalToFeed(2);

        $financeYears = $this->financeYears();
        $requestedYear = (int)($request->input('finances_year') ?? 0);
        $selectedFinanceYear = in_array($requestedYear, $financeYears, true)
            ? $requestedYear
            : ($financeYears[0] ?? (int)now()->year);

        return view('home', [
            'animal' => $animalsToFeed,
            'litter' => $littersToFeed,
            'summary' => $this->animalToFeedSummary($animalsToFeed, 0),
            'summaryLitters' => $this->animalToFeedSummary($littersToFeed, 0),
            'summaryPast' => $this->animalToFeedSummary($animalsToFeed, 1),
            'summaryLittersPast' => $this->animalToFeedSummary($littersToFeed, 1),
            'littersStatus' => $this->litterStatus(),
            'summary_info' => $this->info_data(),
            'financeSummary' => $this->financeSummary($selectedFinanceYear),
            'financeYears' => $financeYears,
            'financeSelectedYear' => $selectedFinanceYear,
        ]);
    }

    public function animalToFeed(int $animalCategoryId = 1): array
    {
        $animal = [];
        $animals = Animal::with('animalFeed')
            ->where('animal_category_id', '=', $animalCategoryId)
            ->get();
        foreach ($animals as $a) {
            $timeToFeed = $this->animalRepo->timeToFeed($a->id);
            if ($timeToFeed <= 1) {
                $a->setAttribute('time_to_feed', $timeToFeed);
                $a->setAttribute('next_feed_date', $this->animalRepo->nextFeed($a->id));
                $animal[] = $a;
            }
        }

        return $animal;
    }

    public function animalToFeedSummary($animalArray, int $fn = 0): array
    {
        $feed = [];
        if (!empty($animalArray)) {
            foreach ($animalArray ?? [] as $a) {
                $timeToFeed = $a->time_to_feed ?? $this->animalRepo->timeToFeed($a->id);
                if ($fn == 1) {
                    if ($timeToFeed <= 0) {
                        $feed[] = $a->animalFeed?->name ?? '';
                    }
                } elseif ($fn == 0) {
                    $feed[] = $a->animalFeed?->name ?? '';
                }
            }

            return array_count_values($feed);
        } else {
            return [];
        }
    }

    public function litterStatus(): array
    {
        $littersLaying = Litter::where('category', 1)
        ->where('connection_date', '!=', null)
        ->where('laying_date', null)
        ->orderBy('connection_date')
        ->get();

        $littersHatching = Litter::where('category', 1)
        ->where('connection_date', '!=', null)
        ->where('laying_date', '!=', null)
        ->where('hatching_date', null)
        ->orderBy('connection_date')
        ->get();

        return $return = [
                    'laying' => $littersLaying,
                    'hatching' => $littersHatching,
                ];
    }

    public function info_data(){

            
            $summary['litter_count'] = Litter::where('category', 1)->count();
            $summary['eggs_count'] = Litter::where('category', 1)->whereNotNull('laying_date')->whereNull('hatching_date')->sum('laying_eggs_ok');
            $summary['for_sale'] = Animal::where('animal_category_id', '=', 2)->count();
            $summary['incubation_total'] = Litter::where('category', 1)->whereNotNull('laying_date')->whereNull('hatching_date')->sum('laying_eggs_ok');
            $summary['planned_income'] = AnimalOffer::whereNull('sold_date')->sum('price');
    
            return $summary;
        
    }

    protected function financeYears(): array
    {
        $years = Finances::selectRaw('YEAR(created_at) as year')
            ->whereNotNull('created_at')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->map(fn ($year) => (int)$year)
            ->toArray();

        if (empty($years)) {
            $years[] = (int)now()->year;
        }

        return $years;
    }

    protected function financeSummary(int $year): array
    {
        $yearIncome = (float) Finances::whereYear('created_at', $year)->where('type', 'i')->sum('amount');
        $yearCosts = (float) Finances::whereYear('created_at', $year)->where('type', 'c')->sum('amount');

        $categoryRaw = Finances::selectRaw('finances_category_id, type, SUM(amount) as total')
            ->whereYear('created_at', $year)
            ->groupBy('finances_category_id', 'type')
            ->get();

        $categories = FinancesCategory::pluck('name', 'id');
        $categorySummary = [];

        foreach ($categoryRaw as $row) {
            $categorySummary[$row->finances_category_id] ??= [
                'name' => $categories[$row->finances_category_id] ?? __('Nieznana kategoria'),
                'income' => 0.0,
                'cost' => 0.0,
            ];

            if ($row->type === 'i') {
                $categorySummary[$row->finances_category_id]['income'] = (float) $row->total;
            } elseif ($row->type === 'c') {
                $categorySummary[$row->finances_category_id]['cost'] = (float) $row->total;
            }
        }

        $categorySummary = array_values(array_filter($categorySummary, function ($data) {
            return ($data['income'] ?? 0) !== 0.0 || ($data['cost'] ?? 0) !== 0.0;
        }));

        $overallIncome = (float) Finances::where('type', 'i')->sum('amount');
        $overallCosts = (float) Finances::where('type', 'c')->sum('amount');

        return [
            'year' => $year,
            'yearTotals' => [
                'income' => $yearIncome,
                'costs' => $yearCosts,
                'profit' => $yearIncome - $yearCosts,
            ],
            'categoryTotals' => $categorySummary,
            'overallTotals' => [
                'income' => $overallIncome,
                'costs' => $overallCosts,
                'profit' => $overallIncome - $overallCosts,
            ],
        ];
    }
}
