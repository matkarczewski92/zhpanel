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
  </section>

