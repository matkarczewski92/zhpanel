<table class="detailsTable">
    <tr class="border-bottom">
        <td style="width:10%">Kod miotu</td>
        <td style="width:10%">Sezon</td>
        <td style="width:10%">Data łączenia</td>
        <td style="width:10%">@if($d->laying_date) Data zniosu @else Data klucia @endif</td>
        <td>Samiec</td>
        <td>Samica</td>
        <td style="width:10%">Status</td>
        <td style="width:5%">Wartość</td>
        <td style="width:5%"></td>
    </tr>
@foreach ($data as $d)
@php
    $layingDuration = systemConfig('layingDuration');
    $hatchlingDuration = systemConfig('hatchlingDuration');
    $date = new DateTime($d->connection_date);
    $date->modify($layingDuration.' days');
@endphp
    <tr>
        <td><a href="{{ route('litters.show', $d->id)}}">{{ $d->litter_code }}</a></td>
        <td>{{ $d->season }}</td>
        <td class="@if(!$d->connection_date) text-secondary @endif">{{ $d->connection_date ?? $d->planned_connection_date }}</td>
        <td class="text-secondary">@if(!$d->laying_date) {{$d->connection_date}} @endif</td>
        <td><a href="{{ route('animal.profile', $d->parent_male)}}">{!! $d->animalMale->name !!}</td>
        <td><a href="{{ route('animal.profile', $d->parent_female)}}">{!! $d->animalFemale->name !!}</td>
        <td>{{ $litterRepo->litterStatus($d->id) }}</td>
        <td>{{ $litterRepo->litterValue($d->id) ?? '' }} zł</td>
        <td> </td>
</tr>
@endforeach
</table>

{{ $data->links() }}


