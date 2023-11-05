<section>
    <div class="block center w-100" id="gallery" style="max-width: 1000px">
        <center>
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
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </center>
      </div>
  </section>



