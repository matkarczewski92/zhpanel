<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Oferta sprzedaży</span>
        </div>
        @if (session()->has('animalOffer'))
        <div class="alert alert-{{ session('animalOfferColor') }} alert-dismissible fade show" role="alert">
            {{ session('animalOffer') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
       @endif
            <table class="detailsTable">
                <tr>
                    <td class="key">Cena</td>
                    <td>{{ $animal->animalOffer->price }} zł</td>
                </tr>
                <tr>
                    <td class="key">Data wystawienia</td>
                    <td>{{ $animal->animalOffer->created_at->format("Y-m-d") }}</td>
                </tr>
                <tr>
                    <td class="key">Data aktualizacji</td>
                    <td>{{ $animal->animalOffer->updated_at->format("Y-m-d") }}</td>
                </tr>
                <tr>
                    <td class="key">Data sprzedaży</td>
                    <td>{{ $animal->animalOffer?->sold_date }}</td>
                </tr>
            </table>
            @if (!empty($animal->animalOffer->offerReservation))
            <div class="strike mb-2">
                <span>Rezerwacja</span>
            </div>
            <table class="detailsTable">
                <tr>
                    <td class="key">Rezerwujący</td>
                    <td>{{ $animal->animalOffer?->offerReservation?->booker }}</td>
                </tr>
                <tr>
                    <td class="key">Zadatek</td>
                    <td>{{ $animal->animalOffer?->offerReservation->deposit }} zł</td>
                </tr>
                <tr>
                    <td class="key">Data rezerwacji</td>
                    <td>{{ $animal->animalOffer?->offerReservation?->created_at->format("Y-m-d") }}</td>
                </tr>
                <tr>
                    <td class="key">Data ważności</td>
                    <td>{{ $animal->animalOffer?->offerReservation?->expiration_date }}</td>
                </tr>
                <tr>
                    <td class="key" colspan="2">Adnotacje</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $animal->animalOffer->offerReservation?->adnotations }}</td>
                </tr>
            </table>

            @endif



    </div>
</div>
