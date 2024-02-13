@extends('layouts.app')

@section('content')

{{$data->where('title', 'Sanctum')->first()['title']}}

{{session('apiToken')}}


@endsection
