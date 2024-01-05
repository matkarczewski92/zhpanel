@extends('layouts.app')

@section('content')

@php
    $months = [
                ['number' => '1','name' => 'Styczeń'],
                ['number' => '2','name' => 'Luty'],
                ['number' => '3','name' => 'Marzec'],
                ['number' => '4','name' => 'Kwiecień'],
                ['number' => '5','name' => 'Maj'],
                ['number' => '6','name' => 'Czerwiec'],
                ['number' => '7','name' => 'Lipiec'],
                ['number' => '8','name' => 'Sierpień'],
                ['number' => '9','name' => 'Wrzesień'],
                ['number' => '10','name' => 'Październik'],
                ['number' => '11','name' => 'Listopad'],
                ['number' => '12','name' => 'Grudzień']
];
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-1 mt-1">
            <div class="card bg-dark photobg rounded-1">
                <div class="card-body text-center" style="">
                Miesiąc
                </div>
            </div>
        </div>
        <div class="col-lg mt-1">
            <div class="card bg-dark photobg rounded-1">
                <div class="card-body text-center text-success" style="">
                Łączenia
                </div>
            </div>
        </div>
        <div class="col-lg mt-1">
            <div class="card bg-dark photobg rounded-1">
                <div class="card-body text-center text-warning" style="">
                Zniosy
                </div>
            </div>
        </div>
        <div class="col-lg mt-1">
            <div class="card bg-dark photobg rounded-1">
                <div class="card-body text-center text-danger" style="">
                Klucia
                </div>
            </div>
        </div>
    </div>
    @foreach ($months as $m)
        @include('litters.components.litters-planning-div', [
            'title' => $m['name'],
            'connection' => $connectionArray[$m['number']] ?? [],
            'laying' => $getLayingArray[$m['number']] ?? [],
            'hatchling' => $getHatchlingArray[$m['number']] ?? [],
            ])
    @endforeach
</div>

@endsection

