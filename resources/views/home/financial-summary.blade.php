@php
    $formatCurrency = fn ($value) => number_format($value, 2, ',', ' ') . ' zł';
@endphp
<div class="card bg-dark photobg rounded-1">
    <div class="card-body">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3 gap-2">
            <div class="strike mb-0">
                <span>Podsumowanie finansowe</span>
            </div>
            @if (!empty($years))
                <form method="GET" action="{{ route('home') }}" class="d-flex align-items-center gap-2">
                    <label for="finances_year" class="form-label text-muted mb-0 small">Rok:</label>
                    <select name="finances_year" id="finances_year" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" @selected($year === $selectedYear)>{{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>

        <div class="row text-center mb-4">
            <div class="col">
                <div class="text-muted small">Przychód ({{ $summary['year'] }})</div>
               <div class="fs-5 text-success">{{ $formatCurrency($summary['yearTotals']['income']) }}</div>
            </div>
            <div class="col">
                <div class="text-muted small">Koszty ({{ $summary['year'] }})</div>
                <div class="fs-5 text-danger">{{ $formatCurrency($summary['yearTotals']['costs']) }}</div>
            </div>
            <div class="col">
                <div class="text-muted small">Dochód ({{ $summary['year'] }})</div>
                <div class="fs-5">{{ $formatCurrency($summary['yearTotals']['profit']) }}</div>
            </div>
        </div>

        @if (!empty($summary['categoryTotals']))
            <div class="table-responsive mb-4">
                <table class="table table-dark table-sm align-middle mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th>Kategoria</th>
                            <th class="text-end">Przychód</th>
                            <th class="text-end">Koszty</th>
                            <th class="text-end">Dochód</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($summary['categoryTotals'] as $category)
                            <tr>
                                <td>{{ $category['name'] }}</td>
                                <td class="text-end text-success">{{ $formatCurrency($category['income']) }}</td>
                                <td class="text-end text-danger">{{ $formatCurrency($category['cost']) }}</td>
                                <td class="text-end">{{ $formatCurrency($category['income'] - $category['cost']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="row text-center">
            <div class="col">
                <div class="text-muted small">Przychód (łącznie)</div>
                <div class="fw-semibold text-success">{{ $formatCurrency($summary['overallTotals']['income']) }}</div>
            </div>
            <div class="col">
                <div class="text-muted small">Koszty (łącznie)</div>
                <div class="fw-semibold text-danger">{{ $formatCurrency($summary['overallTotals']['costs']) }}</div>
            </div>
            <div class="col">
                <div class="text-muted small">Dochód (łącznie)</div>
                <div class="fw-semibold">{{ $formatCurrency($summary['overallTotals']['profit']) }}</div>
            </div>
        </div>
    </div>
</div>
