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
        @if ($offers->isNotEmpty())
            @foreach ($offers as $litterId => $group)
            @php
                $firstOffer = $group->first();
                $litter = $firstOffer->animalDetails->litter ?? null;
            @endphp
                       
                <h3 class="mt-5 mb-4"> <u>{{ $firstOffer->animalDetails->animalLitter->litter_code }} </u>
                  {!! $firstOffer->animalDetails->animalLitter->animalMale->name !!} x 
                  {!! $firstOffer->animalDetails->animalLitter->animalFemale->name !!} </h3>

                <div class="row row-cols-1 row-cols-lg-5 g-4">
                    @foreach ($group as $o)
                        @include('webside.components.animal-offer', ['offer' => $o])
                    @endforeach
                </div>
                <hr>
            @endforeach
        @else
            <p class="text-center">Aktualnie nie posiadamy nadwyżek hodowlanych.</p>
        @endif
      </div> 
      <p class="text-center fw-bold">Nie wydajemy zwierząt osobom nieletnim.</p>
      <p class="text-center">Nie wysyłamy węży kurierem czy przesyłką konduktorską.
      <p class="text-center">Osobniki prezentowane na stronie nie stanowią oferty handlowej w rozumieniu art. 66 Kodeksu cywilnego.</p>
      <p class="text-center mb-4">Prezentowane w profilach informacje mają charakter dokumentacyjny i nie są ofertą w rozumieniu przepisów prawa cywilnego ani handlowego. Ewentualne przekazanie osobników odbywa się wyłącznie na zasadzie prywatnego uzgodnienia.</p>
      

  </section>

