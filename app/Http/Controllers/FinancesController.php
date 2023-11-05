<?php

namespace App\Http\Controllers;

use App\Charts\CostChart;
use App\Models\Finances;
use App\Models\FinancesCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinancesController extends Controller
{

    public function index(): View
    {
        $incomeAmount = Finances::where('type', '=', 'i')->sum('amount');
        $costAmount = Finances::where('type', '=', 'c')->sum('amount');
        // $this->costChart();
        return view('finances', [
            'finances' => Finances::all(),
            'income' => Finances::where('type', '=', 'i')->orderBy('created_at', 'desc')->get(),
            'costs' => Finances::where('type', '=', 'c')->orderBy('created_at', 'desc')->get(),
            'costChart' => $this->chart('c'),
            'incomeChart' => $this->chart('i'),
            'summaryChart' => $this->summaryChart(),
            'incomeAmount' => $incomeAmount,
            'costAmount' => $costAmount,


        ]);
    }


    public function store(Request $request)
    {
        // livewire
    }

    public function update(Request $request, string $id)
    {
        // livewire
    }

    public function destroy(string $id)
    {
        // livewire
    }

    public function summaryChart(): CostChart
    {
        $sum = [];
        $income = Finances::where('type', '=', 'i')->sum('amount');
        $costs = Finances::where('type', '=', 'c')->sum('amount');
        $chart = new CostChart;
        $chart->labels(['Dochody', 'Koszty']);
        $chart->dataset('Costs', 'pie', [$income, $costs])->options([
            'backgroundColor' => ['#3399ff', '#ff3333']
        ]);
        return $chart;
    }
    public function chart($type): CostChart
    {
        $sum = [];
        $categories = FinancesCategory::pluck('name', 'id');
        $count = $categories->count();
        foreach ($categories as $key => $value) {
            $sum[] = Finances::where('finances_category_id', '=', $key)->where('type', '=', $type)->sum('amount');
        }
        $chart = new CostChart;
        $chart->labels($categories->values());
        $chart->dataset('Costs', 'doughnut', $sum)->options([
            'backgroundColor' => ['#2CC34B', '#0D32E5', '#A3981E', '#A95B15', '#83149F', '#B15763', '#D05CAD', '#E38072', '#F5C3F3', '#46B960', '#6D11CB', '#AB22FE', '#1E6048', '#A41BC8', '#476E97', '#003C17', '#EFB09F', '#A2A5E9', '#EB01E7', '#BFE91C', '#0016AD', '#22CD8C', '#28310D', '#53661E', '#367B56', '#85B66E', '#BD433B']
        ]);
        return $chart;
    }
}
