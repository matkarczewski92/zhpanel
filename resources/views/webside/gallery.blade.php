<section>
    <div class="block center w-100" id="gallery" style="max-width: 1000px">
        <center>
            <h3 class="text-center mb-5">Nasze węże   </h3>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="/public/src/x2a.jpg" alt="First slide">
                </div>

                @foreach ($gallery as $g)
                <div class="carousel-item " data-bs-interval="2000">
                    <img src="{{$g->url}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      {{-- <h5>Second slide label</h5> --}}
                      <p class="text-light">{!! $g->animalDetails->name !!}</p>
                    </div>
                  </div>
                @endforeach

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <i class="bi bi-caret-left-fill h2"></i>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <i class="bi bi-caret-right-fill h2"></i>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </center>
      </div>
  </section>



