@extends('layouts.app')

@section('content')


<div class="row ms-2 me-1 mb-5" style="margin-top:-30px !important">

    <div class="row mb-4">
        <div class="col">
            <div class="card bg-dark photobg rounded-1" >
                <div class="text-center">
                        <h5 class="m-2">Zarządzanie hodowlą</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg">
            @include('home.to-weight-animals', ['animal' => $toWeight, 'title' => 'Do ważenia - W hodowli'])
        </div>
        <div class="col-lg-6">
            @include('home.to-feed-animals', ['animal' => $animal, 'summary' => $summary, 'title' => 'Do nakarmienia - W hodowli'])
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6">
            @include('home.to-weight-animals', ['animal' => $toWeightLitters, 'title' => 'Do ważenia - Mioty'])
        </div>
        <div class="col-lg-6">
            @include('home.to-feed-animals', ['animal' => $litter, 'summary' => $summaryLitters, 'title' => 'Do nakarmienia - Mioty'])
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg">
            @include('home.litters-status')
        </div>
        <div class="col-lg-6">

        </div>
    </div>
</div>
@endsection


