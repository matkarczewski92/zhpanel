@extends('layouts.app')

@section('content')

@if (session('litters-status'))
<div class="alert alert-{{ session('litters-status-color') }} alert-dismissible fade show mb-5 me-5 ms-5" role="alert" style="margin-top:-30px">
    {!! session('litters-status') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="text-end me-5" style="margin-top:-30px">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFromTemplate">Dodaj miot z szablonu</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLitter">Dodaj nowy miot</button>
</div>
<div class="card mb-3 me-4 ms-4 mt-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Aktualne mioty</span>
         </div>
         @include('litters.litters-list', ['data' => $littersActual])
    </div>
</div>

<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Planowane mioty</span>
         </div>
         @include('litters.litters-list', ['data' => $littersPlan])
    </div>
</div>

<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Zakończone mioty</span>
         </div>
         @include('litters.litters-list', ['data' => $littersClose])
    </div>
</div>

@include('litters.components.litters-create-from-template-modal')
@include('litters.components.litters-create-modal')

@endsection


