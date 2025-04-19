@extends('layouts.app')

@section('content')

@livewire('animal.animal-photobar', [
    'animal' => $animal
])

<div class="container-fluid mb-3" style="height: 5rem; margin-top:-30px; width:80%;">
    <div class="row bg-dark rounded-3" style="height: 5rem;">
        <div class="col-1 text-center">
            <a href="#" data-bs-toggle="modal" data-bs-target="#photo_profil"><img src="{{$animal->animalMainPhoto->url  ?? ''}}" class="avatar border border-3 border-light" alt="..."></a>
        </div>
        <div class="col-5">
            <div class="position-relative top-50 translate-middle-y">
                <p class="h6 sub-menu fw-bold title-name d-none d-xl-block">{{$animal->second_name}} {{strip_tags($animal->name)}}</p>

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
