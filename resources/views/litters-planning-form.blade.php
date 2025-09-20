@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Planowanie łączeń</span>
             </div>
            @livewire('litters.possible-connection-controller')
    </div>
</div>

@endsection


