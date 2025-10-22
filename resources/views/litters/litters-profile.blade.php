@extends('layouts.app')

@section('content')
@php
    $bannerSource = $litter->litterMainPhoto?->url
        ?? $litter->animalFemale?->animalMainPhoto?->url
        ?? $litter->animalMale?->animalMainPhoto?->url
        ?? 'public/Image/1_20241118051656.jpg';
    $male = $litter->animalMale;
    $female = $litter->animalFemale;
    $incubationEggs = $litter->laying_eggs_ok ?? 0;
    $hatchedEggs = $litter->hatching_eggs ?? 0;
    $totalEggs = $litter->laying_eggs_total ?? 0;
    $offspringCount = $animals->count();
    $fallbackInitial = function ($value) {
        $clean = trim(strip_tags($value));
        if ($clean === '') {
            return '?';
        }

        return \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($clean, 0, 1));
    };
@endphp
@push('styles')
<style>
.litter-profile-avatar,
.litter-profile-avatar-placeholder {
    width:4rem;
    height:4rem;
    object-fit:cover;
    margin-top:-1rem;
}
@media (min-width: 768px) {
    .litter-profile-avatar,
    .litter-profile-avatar-placeholder {
        width:5rem !important;
        height:5rem !important;
        margin-top:-1.5rem !important;
    }
}
</style>
@endpush
<div class="container-fluid background-opacity rounded-bottom-3 div-bg"
     style="height: 19rem; width: 90%; background: url('https://makssnake.pl/{{ $bannerSource }}'); background-size: cover; background-position: center; margin-top: -55px;">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-lg-8">
                <div class="position-relative top-50 translate-middle-y">
                    <p class="display-5 fw-bold mb-1">{{ $litter->litter_code ?? 'Miot bez nazwy' }}</p>
                    <p class="h5 ms-1 mb-0" style="margin-top:-10px;">{{ $category }}@if($litter->season) - Sezon {{ $litter->season }}@endif</p>
                    <div class="d-flex flex-wrap gap-2 ms-1 mt-3">
                        <span class="badge bg-primary text-uppercase px-3 py-2">Status: {{ $status }}</span>
                        @if(!empty($litter->planned_connection_date))
                            <span class="badge bg-success px-3 py-2">Plan &#322;czenia: {{ $litter->planned_connection_date }}</span>
                        @endif
                        @if(!empty($litter->connection_date))
                            <span class="badge bg-success px-3 py-2">&#321;&#261;czenie: {{ $litter->connection_date }}</span>
                        @endif
                        @if(!empty($litter->laying_date))
                            <span class="badge bg-success px-3 py-2">Znios: {{ $litter->laying_date }}</span>
                        @endif
                        @if(!empty($litter->hatching_date))
                            <span class="badge bg-success px-3 py-2">Wyklucie: {{ $litter->hatching_date }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col d-flex flex-column align-items-end">
                <div class="mt-3 me-4 mb-auto d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width:2.4rem; height:2.4rem;" title="Galeria" data-bs-toggle="modal" data-bs-target="#animalProfileGallery">
                        <i class="bi bi-image fs-5 text-dark"></i>
                    </a>
                    <a href="{{ url()->previous() }}" class="h3 p-2" title="Wroc">
                        <i class="fa-solid fa-circle-arrow-left" style="color: #edf3f8;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mb-3" style="margin-top:-30px; width:90%;">
    <div class="row bg-dark rounded-3 align-items-center px-4 py-3 g-3 g-lg-0">
        <div class="col-lg-3 col-md-4 d-flex align-items-center gap-1 pe-0" style="flex: 0 0 30%; max-width: 30%;">
            @if($male?->animalMainPhoto?->url)
                <a href="{{ route('animal.profile', $male->id) }}" class="flex-shrink-0">
                    <img src="{{ $male->animalMainPhoto->url }}" class="rounded-circle border border-3 border-light litter-profile-avatar" alt="">
                </a>
            @else
                <div class="rounded-circle border border-3 border-light d-flex align-items-center justify-content-center text-uppercase flex-shrink-0 litter-profile-avatar-placeholder">
                    {{ $male ? $fallbackInitial($male->name) : '?' }}
                </div>
            @endif
            <div class="d-none d-md-block" style="max-width: 100%; word-break: break-word;">
                <p class="mb-0 text-secondary small text-uppercase">Samiec</p>
                @if($male)
                    <a href="{{ route('animal.profile', $male->id) }}" class="text-white fw-semibold text-decoration-none d-block">{!! $male->name !!}</a>
                @else
                    <span class="text-white">Brak przypisanego samca</span>
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-4 d-flex flex-column align-items-center justify-content-center text-center" style="flex: 0 0 40%; max-width: 40%;">
            <div class="d-inline-flex align-items-center gap-2">
                <span class="fs-6 text-light text-uppercase fw-semibold mb-0">Maluchy w miocie</span>
                <span class="fs-6 fw-bold text-white mb-0">{{ $offspringCount }}</span>
            </div>
            <div class="text-white-50 small">
                Sprzedane / Na sprzedaz: {{ $soldAnimals->count() }} / {{ $totalForSale }}
            </div>
        </div>
        <div class="col-lg-3 col-md-4 d-flex align-items-center justify-content-end gap-1 ps-0" style="flex: 0 0 30%; max-width: 30%;">
            <div class="text-lg-end flex-grow-1 d-none d-md-block" style="word-break: break-word;">
                <p class="mb-0 text-secondary small text-uppercase">Samica</p>
                @if($female)
                    <a href="{{ route('animal.profile', $female->id) }}" class="text-white fw-semibold text-decoration-none d-block">{!! $female->name !!}</a>
                @else
                    <span class="text-white">Brak przypisanej samicy</span>
                @endif
            </div>
            @if($female?->animalMainPhoto?->url)
                <a href="{{ route('animal.profile', $female->id) }}" class="flex-shrink-0">
                    <img src="{{ $female->animalMainPhoto->url }}" class="rounded-circle border border-3 border-light litter-profile-avatar" alt="">
                </a>
            @else
                <div class="rounded-circle border border-3 border-light d-flex align-items-center justify-content-center text-uppercase flex-shrink-0 litter-profile-avatar-placeholder">
                    {{ $female ? $fallbackInitial($female->name) : '?' }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="container-fluid" style="width: 90%; margin-bottom: 50px;">
    <div class="row g-4 align-items-stretch">
        <div class="col-xl-3 col-lg-3 d-flex">
            <div class="w-100 h-100 d-flex flex-column">
                @livewire('litters.adnotations', ['litterId' => $litter->id])
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 d-flex">
            <div class="w-100 h-100 d-flex flex-column">
                @livewire('litters.profile-details', ['litterId' => $litter->id])
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 d-flex">
            <div class="w-100 h-100 d-flex flex-column">
                <div class="flex-grow-1 d-flex">
                    <div class="w-100">
                        @livewire('litters.planning')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 align-items-start mt-1">
        <div class="col-lg-6">
            @livewire('litters.planned-offspring-algoritm', ['litterId' => $litter->id])
        </div>
        <div class="col-lg-6">
            @include('litters.components.litters-sales-summary', ['soldAnimals' => $soldAnimals, 'totalForSale' => $totalForSale])
        </div>
    </div>
    <div class="row g-4 align-items-start mt-1">
        <div class="col-12">
            @livewire('litters.offspring',  ['litterId' => $litter->id])
        </div>
    </div>
</div>

@include('litters.profile.litters-profile-gallery')
@endsection
