<table class="detailsTable">
    <tr class="border-bottom">
        <td style="width:5%">Kod miotu</td>
        <td style="width:5%">Sezon</td>
        <td style="width:7%">Data łączenia</td>
        <td style="width:7%">Data zniosu</td>
        <td style="width:7%">Data klucia</td>
        <td>Samiec</td>
        <td>Samica</td>
        <td style="width:10%">Status</td>
        {{-- <td style="width:5%">Wartość</td> --}}
        <td style="width:5%"></td>
    </tr>
@foreach ($data as $d)
@php
    $layingDuration = systemConfig('layingDuration');
    $hatchlingDuration = systemConfig('hatchlingDuration');
    $conDate = $d->connection_date ?? $d->planned_connection_date;
    $lD = Carbon\Carbon::parse($conDate);
    $layingDate = ($d->laying_date) ? $d->laying_date : $lD->addDays($layingDuration)->format("Y-m-d");

    $hD = Carbon\Carbon::parse($layingDate);
    $hatchingDate = ($d->hatching_date) ? $d->hatching_date : $hD->addDays($hatchlingDuration)->format("Y-m-d");
    // $hatchingDate = $hD->addDays($hatchlingDuration)->format("Y-m-d");
    $connection = Carbon\Carbon::parse($d->connection_date);
    $laying = Carbon\Carbon::parse($layingDate);
    $hatching = Carbon\Carbon::parse($hatchingDate);

@endphp
    <tr>
        <td><a href="{{ route('litters.show', $d->id)}}">{{ $d->litter_code }}</a></td>
        <td>{{ $d->season }}</td>
        <td class="@if(!$d->connection_date) text-secondary @endif">{{ $d->connection_date ?? $d->planned_connection_date }}</td>
        <td class="@if(!$d->laying_date) text-secondary @endif">{{$layingDate}} @if($d->category != 2)({{$laying->diffInDays($connection)}})@endif</td>
        <td class="@if(!$d->hatching_date) text-secondary @endif">{{$hatchingDate}} @if($d->category != 2)({{$hatching->diffInDays($laying)}})@endif</td>
        <td><a href="{{ route('animal.profile', $d->parent_male)}}">{!! $d->animalMale->name !!}</td>
        <td><a href="{{ route('animal.profile', $d->parent_female)}}">{!! $d->animalFemale->name !!}</td>
        <td>{{ $litterRepo->litterStatus($d->id) }}</td>
        {{-- <td>{{ $litterRepo->litterValue($d->id) ?? '' }} zł</td> --}}
        <td> </td>
</tr>
@endforeach
</table>

{{ $data->links() }}


