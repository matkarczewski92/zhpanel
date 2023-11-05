@if(!empty(Session::get('gallery')) && Session::get('gallery') == 1)
<script>
$(function() {
    $('#animalProfileGallery').modal('show');
});
</script>
@endif

<div class="modal fade" id="animalProfileGallery" tabindex="-1" aria-labelledby="animalProfileGallery" aria-hidden="true" style="z-index: 10000;">

    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="animalProfileGallery">Galeria zdjęć</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            @if (session('gallery_add'))
            <div class="alert alert-success" role="alert">
                {{ session('gallery_add') }}
            </div>
            @endif
            <div class="strike m-3">
                <span>Dodaj zdjęcie</span>
             </div>
             <div class="col">
                    <div class="card text-center mb-3" style="max-width: 50%; margin:auto">
                        <img id="output" class="card-img-top" >
                    </div>
            </div>
            <form action="{{ route('animal.gallery', ['id'=>$animal->id]) }}" method="post" enctype="multipart/form-data">
            @csrf <!-- {{ csrf_field() }} -->
            <div class="input-group">
                <input type="file" class="form-control" onchange="loadFile(event)" id="inputGroupFile04" name="image" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Dodaj nowe zdjęcie</button>
            </div>
            </form>
            </div>
            <div class="modal-body">
            <div class="strike m-3">
                <span>Galeria</span>
             </div>
             {{-- dd() --}}


            <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($animal->animalGallery as $photo)
                <div class="col">
                    <div class="card @if($photo->main_profil_photo == 1) bg-light @endif">
                   <img src="{{$photo->url}}" class="card-img-top"alt="...">
                        <div class="card-body text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-danger" href="{{ route('animal.imagedelete', ['id' => $photo->id])}}" role="button">Usuń</a>
                                @if(!$photo->main_profil_photo == 1)
                                <a class="btn btn-success" href="{{ route('animal.imagesetmain', ['id' => $photo->id])}}" role="button">Ustaw jako główne</a>
                                 @endif
                              </div>
                        </div>
                    </div>
                </div>
             @endforeach
            </div>
              {{--  --}}
        </div>

        <div class="modal-footer">

            <br/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
        </div>
      </div>
    </div>
  </div>



  <script>

    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src)
      }
    };
  </script>
