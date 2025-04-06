@extends('layouts.app')

@section('content')

<div class="row ms-2 me-1 mb-5">
    <div class="col col-1 stGtx" style="">
        {{-- @include('animals.profile.sidebar') --}}
        @livewire('animal.animal-profile-sidebar', ['animalId' => $animal->id])
    </div>

    <div class="col" style="margin-top: -20px;">
        <div class="row">
            <div class="col-lg">
                @include('animals.profile.animal-profile-photo')
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


@include('animals.profile.animal-profile-offer-modal')
@include('livewire.animal.animal-profile-gallery')
</div>
@endsection
