<?php

namespace App\Http\Controllers;

use App\Charts\FeedConsumptionChart;
use App\Models\AnimalFeedings;
use App\Models\Feed;
use App\Models\Finances;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        return view('feed', [
            'feed' => Feed::all(),
            'chart' => $this->consumptionChart($request->year),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $feed = new Feed;
        $feed->name = $request->name;
        $feed->feeding_interval = $request->feeding_interval;
        $feed->amount = $request->amount;
        $feed->last_price = $request->last_price;
        $feed->save();
        return redirect()
            ->route('feeds.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        return view('feed.feed-profile', [
            'feed' => Feed::find($id),
            'costs' => Finances::where('feed_id', '=', $id)->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // by livewire
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $feed = Feed::find($id);
        $feed->name = $request->name;
        $feed->feeding_interval = $request->feeding_interval;
        $feed->amount = $request->amount;
        $feed->last_price = $request->last_price;
        $feed->save();
        return redirect()
            ->route('feed.profile', $id)
            ->with('feed-status', 'Edytowano pomyślnie')
            ->with('feed-status-color', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Feed::find($id)->delete();
        return redirect()
            ->route('feeds.index')
            // ->with('feed-status', 'Edytowano pomyślnie')
            // ->with('feed-status-color', 'warning')
        ;
    }

    private function consumptionChart(int $year = null): FeedConsumptionChart
    {
        $year = (is_null($year) || $year == '') ? date("Y") : $year;
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $label = "";
        $fc = Feed::all();
        $label = substr_replace($label, "", -1);
        $chart = new FeedConsumptionChart;
        $chart->labels($months);
        foreach ($fc as $cat) {
            $amount = [];
            foreach ($months as $mo) {
                $feedings = AnimalFeedings::where('feed_id', '=', $cat->id)
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $mo)
                    ->select(DB::raw("sum(amount) as sum"))
                    ->get();
                foreach ($feedings as $feed) {
                    $sum = ($feed->sum < 1) ? 0 : $feed->sum;
                    $amount[] = $sum;
                }
            }
            $chart->dataset($cat->name, 'bar', $amount)->options([
                'backgroundColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            ]);
        }
        return $chart;
    }
}
