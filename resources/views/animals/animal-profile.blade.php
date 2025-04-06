@extends('layouts.app')

@section('content')

<div class="container-fluid background-opacity rounded-bottom-3 div-bg" 
style="height: 15rem; width: 90%; background: url('https://makssnake.pl/{{$animal->animalMainPhoto->url ?? 'public/Image/1_20241118051656.jpg'}}'); background-size: cover; background-position: center {{$animal->animalMainPhoto->banner_possition ?? 10}}%; margin-top: -55px;">
    <div class="container-fluid h-100 " style="width: 100%;">
        <div class="row h-100 ">
            <div class="col-8">
                <div class="position-relative top-50 start-0 translate-middle-y" style="margin-top: -10px;">
                    <!-- <p class="h2 title fw-bold">Profil węża</p> -->
                    <p class="h2 title fw-bold">{{strip_tags($animal->name)}}</p>
                    <p class="title ms-1" style="margin-top:-15px">Wąż w hodowli ({{$animal->animalMainPhoto->banner_possition}})</p>
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
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mb-3" style="height: 5rem; margin-top:-30px; width:80%;">
    <div class="row bg-dark rounded-3" style="height: 5rem;">
        <div class="col-1 text-center">
            <a href="#" data-bs-toggle="modal" data-bs-target="#photo_profil"><img src="{{$animal->animalMainPhoto->url  ?? ''}}" class="avatar border border-3 border-light" alt="..."></a>
        </div>
        <div class="col-5">
            <div class="position-relative top-50 translate-middle-y">
                <p class="h6 sub-menu fw-bold title-name d-none d-xl-block">{{strip_tags($animal->name)}}</p>

            </div>
        </div>
        <div class="col-6">
            <div class="position-relative top-50 translate-middle-y text-end">
                @livewire('animal.animal-profile-sidebar', ['animalId' => $animal->id])
                {{-- <a class="h3 p-2" href="" role="button" data-bs-toggle="tooltip" data-bs-title="Karmienie"><i class="bi bi-cup-hot text-danger"></i></a>
                <a class="h3 p-2 " href="" role="button" data-bs-toggle="tooltip" data-bs-title="Ważenie"><i class="bi bi-speedometer text-danger"></i></a>
                <a class="h3 p-2 " href="" role="button" data-bs-toggle="tooltip" data-bs-title="Zimowanie"><i class="bi bi-snow text-primary"></i></a>
                <a class="h3 p-2 " href="" role="button" data-bs-toggle="tooltip" data-bs-title="Galeria"><i class="bi bi-image text-secondary"></i></a>
                <a class="h3 p-2 " href="" role="button" data-bs-toggle="tooltip" data-bs-title="Oferta"><i class="bi bi-coin text-primary"></i></a>
                <a class="h3 p-2 " href="" role="button" data-bs-toggle="tooltip" data-bs-title="Certyfikat"><i class="bi bi-passport text-secondary"></i></a> --}}
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="width: 91%; margin-bottom: 20px;">
    <div class="row g-4 ">
        <div class="col-lg-3">
            {{-- @include('animals.profile.animal-profile-photo') --}}
            {{-- @include('animals.profile.animal-profile-details') --}}
            @livewire('animal.animal-profile-details', [
                'animalId' => $animal->id,
                'feedId' => $animal->feed_id,
                'sex' => $animal->sex,
            ])
            @livewire('animal.animal-profile-genotype', ['animalId' => $animal->id])
        </div>
        <div class="col-lg-6">
            @livewire('animal.animal-feedings-profile', ['animalId' => $animal->id])
            @include('animals.profile.animal-profile-weight')
            @livewire('animal.animal-wintering-profile', ['animalId' => $animal->id])

        </div>
        <div class="col-lg">
            @if (!empty($animal->animalOffer))
            @include('animals.profile.animal-profile-offer')
            @endif
            @include('animals.profile.animal-profile-litters')
            @livewire('animal.animal-molts-profile', ['animalId' => $animal->id])
        </div>
    </div>
</div>
</div>
<script>
$(document).ready( function () {
$('#detailsTable').DataTable();
} );
</script>


@include('animals.profile.animal-profile-offer-modal')
@include('livewire.animal.animal-profile-gallery')
</div>
<div class="modal fade" id="photo_profil" tabindex="-1" aria-labelledby="photo_profil" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
      <div class="modal-content bg-dark photobg">
        <div class="modal-header border-0" >
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body" style="top: -25px">
            <a href="#" data-bs-dismiss="modal"><img src="{{ $animal->animalMainPhoto?->url }}" class="img-fluid " alt=""></a>
        </div>

      </div>
    </div>
  </div>
@endsection
