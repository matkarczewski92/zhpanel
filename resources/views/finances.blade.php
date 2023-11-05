@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5" style="margin-top:-35px">
    <div class="col-lg-3 mt-3">
        @include('finances.finance-summary')
    </div>
    <div class="col-lg-9 mt-3">
        @livewire('finances.finance-last-transfers')
    </div>
    <div class="col-lg-3 mt-3">
        @include('finances.finance-cost-summary')
    </div>
    <div class="col-lg-3 mt-3">
        @include('finances.finance-income-summary')
    </div>
    <div class="col-lg-3 mt-3">
        @livewire('finances.finance-create-transaction')
    </div>
    <div class="col-lg-3 mt-3">
        @livewire('finances.finance-categories')
    </div>
</div>
@endsection


