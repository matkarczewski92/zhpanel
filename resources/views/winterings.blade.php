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
                    <td class="text-center">Waga</td>
                    <td class="text-center border-start ">Aktualny etap</td>
                    <td class="text-center">Początek</td>
                    <td class="text-center border-end">Koniec</td>
                    <td class="text-center">Początek zimowania</td>
                    <td class="text-center">Koniec zimowania</td>
                </tr>
                {{-- {{dd($winterings)}} --}}
                @foreach ($winterings as $wt)
                @php
                    $stageDetails = $winteringRepo->getWinteringStageDetails($wt->id, $winteringRepo->winteringActualStage($wt->id)['stage']);
                @endphp
                    <tr>
                        <td>{{ $wt->id }}</td>
                        <td><a href="{{ route('animal.profile', $wt->id)}}">{!! $wt->name !!}</a></td>
                        <td class="text-center">{{ $animalRepo->lastWeight($wt->id) }} g.</td>
                        <td class="text-center border-start">{{ $winteringRepo->winteringActualStage($wt->id)['stage'] }}. {{ $winteringRepo->winteringActualStage($wt->id)['title'] }}</td>
                        <td class="text-center ">{{ $stageDetails->start_date ?? $stageDetails->planned_start_date }}</td>
                        <td class="text-center  border-end">{{ $stageDetails->planned_end_date }}</td>
                        <td class="text-center">{{ $winteringRepo->winteringStart($wt->id) }}</td>
                        <td class="text-center">{{ $winteringRepo->winteringEnd($wt->id) }}</td>

                    </tr>
                @endforeach
             </table>
                </div>
            </div>

</div>

@endsection


