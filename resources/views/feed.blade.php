@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5">
    <div class="col " style="margin-top: -20px">
        <div class="row">
            <div class="col-lg-8">
                {{-- @include('feed.components.feed-list') --}}
                @livewire('feed.feed-list')

                @include('feed.components.feed-consumption')

                @livewire('feed.feed-planning')

            </div>
            <div class="col-lg-4">
                @include('feed.components.feed-create-form')

                @livewire('feed.feed-receipt')

            </div>
        </div>
    </div>
</div>
@endsection


