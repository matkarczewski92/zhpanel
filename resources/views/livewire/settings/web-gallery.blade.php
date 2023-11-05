<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Galeria</span>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($gallery as $photo)
                <div class="col-lg-2">
                    <div class="card @if($photo->webside == 1) bg-light @endif">
                   <a href="{{ route('animal.profile', $photo->animal_id)}}"><img src="{{$photo->url}}" class="card-img-top"alt="..."></a>
                        <div class="card-body text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @if(!$photo->webside == 1)
                                <button class="btn btn-success" wire:click="galleryStatus({{$photo->id}})" role="button">Dodaj do gallerii</button>
                                @else
                                <button class="btn btn-danger" wire:click="galleryStatus({{$photo->id}})" role="button">Usuń z gallerii</button>
                                 @endif
                              </div>
                        </div>
                    </div>
                </div>
             @endforeach
            </div>
    </div>
</div>


