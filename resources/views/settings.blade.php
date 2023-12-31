@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="row ">
                <div class="col-lg-6">
                    @livewire('settings.settings-animal-category')
                </div>
                <div class="col-lg-6">
                    @livewire('settings.settings-animal-type')

                </div>
            </div>

            <div class="row ">
                <div class="col-lg-6">
                    @livewire('settings.system-config')
                </div>
                <div class="col-lg-6">
                    @livewire('settings.settings-animal-witering')
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="col-lg">
                @livewire('settings.settings-animal-genotype')
            </div>
        </div>
    </div>
</div>
@endsection


