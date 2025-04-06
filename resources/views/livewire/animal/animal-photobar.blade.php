<div>
    <div class="container-fluid background-opacity rounded-bottom-3 div-bg" 
style="height: 17rem; width: 90%; background: url('https://makssnake.pl/{{$animal->animalMainPhoto->url ?? 'public/Image/1_20241118051656.jpg'}}'); background-size: cover; background-position: center {{$animal->animalMainPhoto?->banner_possition ?? 10}}%; margin-top: -55px;">
    <div class="container-fluid h-100 " style="width: 100%;">
        <div class="row h-100 ">
            <div class="col-8">
                <div class="position-relative top-50 start-0 translate-middle-y" style="margin-top: -10px;">
                    <!-- <p class="h2 title fw-bold">Profil węża</p> -->
                    <p class="h2 title fw-bold">{{strip_tags($animal->name)}}</p>
                    <p class="title ms-1" style="margin-top:-15px">{{ $animal->animalCategory?->name }}</p>
                </div>
            </div>
            <div class="col-1">
                
            </div>
            <div class="col">
                <div class="mt-3 text-end me-4 ">
                    <a href="{{ url()->previous() }}" class="h3 p-2 ms-5" aria-current="page" title="Wróć">
                        <i class="fa-solid fa-circle-arrow-left" style="color: #edf3f8;"></i>
                    </a>
                    {{-- <a class="h3 disabled p-2" href="" role="button"><i class="bi bi-plus-square"></i></a> --}}
                    <a href="{{ route('animals.edit', $animal->id) }}" class="h3 p-2" aria-current="page" title="Edytuj">
                        <i class="bi bi-pencil-square" style="color: #edf3f8;"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="mt-5 text-end me-4 ">
                        <a href="#" wire:click.prevent='bannerUp'><i class="bi bi-chevron-double-up"></i></a><br>
                        <a href="#" wire:click.prevent='bannerDown'><i class="bi bi-chevron-double-down"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
