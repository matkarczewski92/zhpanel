@extends('layouts.app')

@section('content')

{{$data->where('title', 'Sanctum')->first()['title']}}

{{-- @foreach ($data->where('title', 'api 2') as $d)
    {{$d['title']}}
@endforeach --}}


@endsection
