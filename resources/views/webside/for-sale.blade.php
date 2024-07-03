<section>
    <div class="parallax-two" id="offer">
      <h2>NADWYŻKI HODOWLANE</h2>
    </div>
  </section>

  <section>
      <div class="block" style="min-height: 300px">
          <h3 class="text-center mb-5">Nadwyżki hodowlane  </h3>
          <h3 class="text-center mb-5">przeznaczone do sprzedaży </h3>

          @if (!empty($offers[0]))
          <div class="row row-cols-1 row-cols-lg-5 g-4">
            @foreach ($offers ?? [] as $o)
                @if ($o->animalDetails->public_profile == 1)
                    @include('webside.components.animal-offer', ['offer' => $o])
                @endif
            @endforeach
          </div>
          @else
          <p class="text-center">Brak węży na sprzedaż</p>
        @endif
      </div> 
      <p class="text-center fw-bold">Nie sprzedajemy zwierząt osobą nieletnim.</p>
      <p class="text-center">Nie wysyłamy węży kurierem czy przesyłką konduktorską. Możliwy dowóz w okolicy Wejherowa (woj.pomorskie) lub na dworzec np. w Gdynii.
      <p class="text-center mb-4">Możliwa rezerwacja, warunkiem rezerwacji jest wpłata zadatku, rezerwujemy zazwyczaj na okres miesiąca (w wyjątkowych sytuacjach na dłuższy okres uzgodniony indywidualnie)</p>
  </section>

