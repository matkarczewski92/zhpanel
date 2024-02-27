@extends('layouts.app')

@section('content')

<div class="container-fluid">
    @foreach ($data as $d)
        {{$d['sensor_id']}} :
        {{$d['value']}} stC<br>
    @endforeach
    {{-- {{dd($data)}} --}}
</div>




@endsection
