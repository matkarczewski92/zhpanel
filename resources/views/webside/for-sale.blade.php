<section>
    <div class="parallax-two" id="offer">
      <h2>NADWYŻKI HODOWLANE</h2>
    </div>
  </section>

  <section>
      <div class="block" style="min-height: 300px">
          <h3 class="text-center mb-5">Nadwyżki hodowlane</h3>
          <h3 class="text-center mb-3">osobniki wyłączone z dalszych planów hodowlanych – dostępne do przekazania pasjonatom</h3>
          <br/>

          @if (!empty($offers[0]))
          <div class="row row-cols-1 row-cols-lg-5 g-4">
            @foreach ($offers ?? [] as $o)
                @if ($o->animalDetails->public_profile == 1)
                    @include('webside.components.animal-offer', ['offer' => $o])
                @endif
            @endforeach
          </div>
          @else
          <p class="text-center">Aktualnie nie posiadamy nadwyżek hodowlanych.</p>
        @endif
      </div> 
      <p class="text-center fw-bold">Nie wydajemy zwierząt osobom nieletnim.</p>
      <p class="text-center">Nie wysyłamy węży kurierem czy przesyłką konduktorską.
      <p class="text-center">Osobniki prezentowane na stronie nie stanowią oferty handlowej w rozumieniu art. 66 Kodeksu cywilnego.</p>
      <p class="text-center mb-4">Prezentowane w profilach informacje mają charakter dokumentacyjny i nie są ofertą w rozumieniu przepisów prawa cywilnego ani handlowego. Ewentualne przekazanie osobników odbywa się wyłącznie na zasadzie prywatnego uzgodnienia.</p>
      

  </section>

