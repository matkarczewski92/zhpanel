@extends('layouts.app')

@section('content')

<div class="text-end me-5 mb-4" style="margin-top:-30px">
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProject">Etykiety</button> --}}
</div>
<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Etykiety</span>
         </div>
         {{-- @foreach ($animals as $a)
             {{$a->id}}<br>
         @endforeach --}}
    </div>
</div>
@endsection
