@extends('layouts.app')

@section('content')

<div class="container-fluid">

    @livewire('massdata.mass-data', ['title' => 'Zwierzęta w hodowli', 'category' => 1])

    @livewire('massdata.mass-data', ['title' => 'Mioty', 'category' => 2])

</div>

@endsection


