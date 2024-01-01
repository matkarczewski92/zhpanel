@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Zimowanie</span>
             </div>

             <table class="detailsTable">
                <tr class="border-bottom">
                    <td>ID</td>
                    <td>Nazwa</td>
                    <td>Waga</td>
                    <td class="text-center">Aktualny etap</td>
                    <td class="text-center">Początek zimowania</td>
                    <td class="text-center">Koniec zimowania</td>
                </tr>
                {{-- {{dd($winterings)}} --}}
                @foreach ($winterings as $wt)
                    <tr>
                        <td>{{ $wt->id }}</td>
                        <td><a href="{{ route('animal.profile', $wt->id)}}">{!! $wt->name !!}</a></td>
                        <td>{{ lastWeight($wt->id) }}</td>
                        <td class="text-center">{{ winteringActualStage($wt->id)['stage'] }}. {{ winteringActualStage($wt->id)['title'] }}</td>
                        <td class="text-center">{{ winteringStart($wt->id) }}</td>
                        <td class="text-center">{{ winteringEnd($wt->id) }}</td>

                    </tr>
                @endforeach
             </table>
                </div>
            </div>

</div>

@endsection


