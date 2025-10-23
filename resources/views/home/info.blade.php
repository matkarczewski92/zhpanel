<div class="row mb-4">
    <div class="col">
        <div class="card bg-dark photobg rounded-1">
            <div class="text-center">
                <h5 class="m-2 mt-2">{{ $summary_info['eggs_count'] }} / {{ $summary_info['incubation_total'] }}</h5>
                <h6 class="m-2">Ilość jaj w inkubacji / ogółem w inkubatorach</h6>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-dark photobg rounded-1">
            <div class="text-center">
                <h5 class="m-2 mt-2">{{ $summary_info['for_sale'] }}</h5>
                <h6 class="m-2">Ilość maluchów na sprzedaż</h6>
                <p class="mb-2 text-muted small">Planowany przychód: {{ number_format($summary_info['planned_income'], 2, ',', ' ') }} zł</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-dark photobg rounded-1">
            <div class="text-center">
                <h5 class="m-2 mt-2">{{ $summary_info['litter_count'] }}</h5>
                <h6 class="m-2">Aktualna liczba miotów</h6>
            </div>
        </div>
    </div>
</div>
