@extends('layouts.app')

@section('content')

<div class="row m-1" >
    <div class="text-end me-5" style="margin-top:-30px">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLitter">Dodaj nowy szablon</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#possibleConnection">Możliwe połączenia</button>
    </div>
    @foreach ($females ?? [] as $f)
    <div class="col-lg-4 col-12 mt-3" >
        <div class="card  bg-dark photobg rounded-1 h-100">
            <div class="card-body " style="">
                <div class="strike mb-2">
                    <span>{!! $f->name !!} </span>
                 </div>
                 @php
                     $litter = App\Models\Litter::where('parent_female','=', $f->id)->where('category','=', 3)->get();
                 @endphp
                 <table class="detailsTable">
                    @foreach ($litter as $l)
                    @php
                        $male = App\Models\Animal::find($l->parent_male);
                    @endphp
                    <tr>
                        <td><a href="{{ route('availableconnections.show', $l->id) }}">{!!$male->name!!}</a></td>
                        <td><a href="{{ route('availableconnections.show', $l->id) }}">{!!$l->litter_code!!}</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endforeach

</div>
@include('litters.components.litters-create-modal', ['animalsMale' => $males, 'animalsFemale' => $females, 'part' => 'availableconnections'])
<div class="modal fade" id="possibleConnection" tabindex="-1" aria-labelledby="possibleConnectionLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="possibleConnectionLabel" class="modal-title">Możliwe połączenia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
            </div>
            <div class="modal-body">
                @livewire('litters.possible-connection-controller')
            </div>
        </div>
    </div>
</div>


@endsection

