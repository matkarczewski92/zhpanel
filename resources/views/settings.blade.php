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
                    <div class="card mb-3">
                        <div class="card-header">{{ __('4A') }}</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <a href="{{ route('settings.index') }}">test</a>
                        </div>
                    </div>
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


