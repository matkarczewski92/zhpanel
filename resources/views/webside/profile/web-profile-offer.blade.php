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
                    <td>{{ $animal->animalOffer->price ?? '' }} zł</td>
                </tr>
                <tr>
                    <td class="key">Data wystawienia</td>
                    <td>
                        @if ($animal->animalOffer?->created_at)
                            {{ $animal->animalOffer->created_at->format("Y-m-d") ?? '' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="key">Data sprzedaży</td>
                    <td>{{ $animal->animalOffer?->sold_date }}</td>
                </tr>
            </table>

            @if(!is_null($animal->animalOffer?->offerReservation?->booker))
                <div class="strike mb-2 text-danger">
                    <span>Rezerwacja</span>
                </div>
            @endif


<p class="text-center">Warunkiem rezerwacji jest wpłata zadatku, rezerwujemy zazwyczaj na okres miesiąca (w wyjątkowych sytuacjach na dłuższy okres uzgodniony indywidualnie)</p>
    </div>
</div>
