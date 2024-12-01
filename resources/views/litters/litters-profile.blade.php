@extends('layouts.app')

@section('content')
<div class="container-fluid" style="max-width: 100%">
    <div class="row ">
        <div class="col-lg-3 content-to-hide">
            @include('litters.components.litters-profile-parent-photo', ['data' => $litter->animalMale])
        </div>
        <div class="col-lg-6">
            @livewire('litters.profile-details', ['litterId' => $litter->id])
        </div>

        <div class="col-lg-3 content-to-hide">
            @include('litters.components.litters-profile-parent-photo', ['data' => $litter->animalFemale])
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-3">
            @livewire('litters.adnotations', ['litterId' => $litter->id])

        </div>
        <div class="col-lg-6">
            {{-- @livewire('litters.planned-offspring', ['litterId' => $litter->id]) --}}
            @livewire('litters.planned-offspring-algoritm', ['litterId' => $litter->id])
        </div>
        <div class="col-lg-3">
            @livewire('litters.planning')
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-8">
            @livewire('litters.offspring',  ['litterId' => $litter->id])
        </div>
        <div class="col-lg-4">
            @include('litters.components.litters-main-photo')
        </div>


    </div>
</div>
@include('litters.profile.litters-profile-gallery')
@endsection

