<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\Animal;
use App\Models\Litter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LitterController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    public function index(): View
    {
        return view('litters', [
            'littersActual' => Litter::where('category', 1)->orderBy('connection_date', 'asc')->paginate(25),
            'littersPlan' => Litter::where('category', 2)->orderByRaw('COALESCE(connection_date, planned_connection_date) ASC')->paginate(50),
            'littersClose' => Litter::where('category', 4)->orderBy('season', 'desc')->paginate(15),
            'plannedSeasons' => Litter::where('category', 2)
                ->whereNotNull('season')
                ->select('season')
                ->distinct()
                ->orderBy('season', 'desc')
                ->pluck('season'),
            'animalsMale' => Animal::where('sex', 2)->where(function ($query) {
                $query->where('animal_category_id', 1)
                ->orWhere('animal_category_id', 4);
            })->get(),
            'animalsFemale' => Animal::where('sex', 3)->where(function ($query) {
                $query->where('animal_category_id', 1)
                ->orWhere('animal_category_id', 4);
            })->get(),
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
        ]);
    }

    public function store(Request $request)
    {
        $litter = new Litter();
        $litter->litter_code = $request->litter_code;
        $litter->season = $request->season;
        $litter->category = $request->category;
        $litter->parent_male = $request->parent_male;
        $litter->parent_female = $request->parent_female;
        $litter->save();

        if ($request->category == '3') {
            return redirect()
                ->route('availableconnections.index')
                ->with('litters-status', 'Dodano nowy miot')
                ->with('litters-status-color', 'success');
        } else {
            return redirect()
                    ->route('litters.index')
                    ->with('litters-status', 'Dodano nowy miot')
                    ->with('litters-status-color', 'success');
        }
    }

    public function show(string $id)
    {
        $litter = Litter::find($id);

        $animals = Animal::with('animalOffer')->where('litter_id', $id)->get();
        $soldAnimals = $animals->filter(function ($animal) {
            return !empty($animal->animalOffer?->sold_date);
        })->sortBy(function ($animal) {
            return $animal->animalOffer?->sold_date;
        })->values();
        $totalForSale = $animals->filter(function ($animal) {
            return !is_null($animal->animalOffer);
        })->count();

        return view('litters.litters-profile', [
            'litter' => $litter,
            'category' => $this->litterRepo->litterCategory($litter->category),
            'animals' => $animals,
            'soldAnimals' => $soldAnimals,
            'totalForSale' => $totalForSale,
            'status' => $this->litterRepo->litterStatus($litter->id),
            'animalRepo' => $this->animalRepo,
        ]);
    }

    public function destroy(string $id)
    {
    }

    public function bulkDestroyPlanned(Request $request)
    {
        $validated = $request->validate([
            'season' => ['required', 'integer'],
        ]);

        $season = (int) $validated['season'];
        $currentYear = (int) now()->format('Y');

        if ($season < $currentYear) {
            return redirect()
                ->route('litters.index')
                ->with('litters-status', "Sezon {$season} jest w przeszlosci, nic nie usunieto.")
                ->with('litters-status-color', 'warning');
        }

        $today = now()->toDateString();

        $eligibleQuery = Litter::where('category', 2)
            ->where('season', $season)
            ->whereNull('connection_date')
            ->where(function ($query) use ($today) {
                $query->whereNull('planned_connection_date')
                    ->orWhere('planned_connection_date', '>=', $today);
            });

        $deletableCount = (clone $eligibleQuery)->count();

        if ($deletableCount === 0) {
            $hasSeason = Litter::where('category', 2)->where('season', $season)->exists();

            return redirect()
                ->route('litters.index')
                ->with(
                    'litters-status',
                    $hasSeason
                        ? "Brak miotow do usuniecia w sezonie {$season}. Sprawdz daty laczenia."
                        : "Brak planowanych miotow dla sezonu {$season}."
                )
                ->with('litters-status-color', $hasSeason ? 'info' : 'warning');
        }

        $eligibleQuery->delete();

        $blockedCount = Litter::where('category', 2)
            ->where('season', $season)
            ->count();

        $message = "Usunieto {$deletableCount} planowanych miotow z sezonu {$season}.";

        if ($blockedCount > 0) {
            $message .= " Pominieto {$blockedCount} miotow (posiadaja date laczenia albo termin w przeszlosci).";
        }

        return redirect()
            ->route('litters.index')
            ->with('litters-status', $message)
            ->with('litters-status-color', 'success');
    }
}
