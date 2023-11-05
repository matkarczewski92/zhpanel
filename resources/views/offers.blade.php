@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>{{ $title }}</span>
             </div>

             <table class="detailsTable">
                <tr class="border-bottom">
                    <td>Kod miotu</td>
                    <td>Zwierzę</td>
                    <td>Cena</td>
                    <td>Data</td>
                    <td>Rezerwacja</td>
                </tr>
                @foreach ($offers as $o)
                    <tr>
                        <td>{!!$o->animalDetails->animalLitter?->litter_code!!}</td>
                        <td><a href="{{ route('animal.profile', $o->animalDetails->id) }}">{!!$o->animalDetails->name!!}</a></td>
                        <td>{{$o->price}} zł</td>
                        <td>{{$o->created_at->format("Y-m-d")}}</td>
                        <td>{{$o->offerReservation->booker ?? ''}}</td>
                    </tr>
                @endforeach
             </table>
                </div>
            </div>

</div>

@endsection


