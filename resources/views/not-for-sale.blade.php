@extends('layouts.app')

@section('content')

@include('notforsale.not-for-sale-list', ['animal' => $animal]);

@livewire('nfs.not-for-sale-add')
@endsection
