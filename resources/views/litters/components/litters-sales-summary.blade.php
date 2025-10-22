<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body">
        <div class="strike mb-2">
            <span>Historia sprzedazy miotu ({{ $soldAnimals->count() }} / {{ $totalForSale }})</span>
        </div>
        @if($soldAnimals->isEmpty())
            <p class="text-white-50 mb-0">Brak zrealizowanych sprzedazy dla tego miotu.</p>
        @else
            @php
                $totalRevenue = $soldAnimals->reduce(function ($carry, $animal) {
                    return $carry + (float) ($animal->animalOffer?->price ?? 0);
                }, 0.0);
            @endphp
            <table class="detailsTable">
                <tr class="border-bottom">
                    <td>ID</td>
                    <td>Nazwa</td>
                    <td class="text-center">Cena</td>
                    <td class="text-center">Data sprzedazy</td>
                </tr>
                @foreach ($soldAnimals as $sold)
                    @php
                        $price = $sold->animalOffer?->price;
                        $soldDate = $sold->animalOffer?->sold_date
                            ? \Carbon\Carbon::parse($sold->animalOffer->sold_date)->format('Y-m-d')
                            : 'brak';
                    @endphp
                    <tr>
                        <td class="small text-white-50">{{ $sold->id }}</td>
                        <td>
                            <a href="{{ route('animal.profile', $sold->id) }}" class="text-white text-decoration-none">
                                {!! $sold->name !!}
                            </a>
                        </td>
                        <td class="text-center">
                            {{ $price !== null ? number_format((float) $price, 2, ',', ' ') . ' zl' : 'brak' }}
                        </td>
                        <td class="text-center">{{ $soldDate }}</td>
                    </tr>
                @endforeach
                <tr class="border-top">
                    <td colspan="2" class="text-end text-uppercase small text-white-50">Suma</td>
                    <td class="text-center fw-semibold text-white">
                        {{ number_format($totalRevenue, 2, ',', ' ') }} zl
                    </td>
                    <td></td>
                </tr>
            </table>
        @endif
    </div>
</div>
