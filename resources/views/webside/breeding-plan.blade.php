<section>
    <div class="parallax-six" id="plans">
      <h2>PLANY HODOWLANE</h2>
    </div>
  </section>

  <section>
      <div class="block text-center"  style="min-height: 300px">
          <h3 class="text-center mb-5">Plany hodowlane na bieżący rok  </h3>
        @foreach ($litterPlans as $lP)
            <p>{!! $lP->animalMale->name !!}  <i class="bi bi-arrow-through-heart-fill h4 @if($lP->category == 1) text-danger @endif"></i> {!! $lP->animalFemale->name !!}
            @if($lP->category == 1) <i class="bi bi-check-lg h4 text-success"></i> @else <i class="bi bi-question-lg h4"></i> @endif</p>
        @endforeach

      </div>
  </section>

