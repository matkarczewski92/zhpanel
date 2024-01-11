<table class="detailsTable">
    <tr class="border-bottom">
        <td style="width:10%">Kod miotu</td>
        <td style="width:10%">Sezon</td>
        <td style="width:10%">Data łączenia</td>
        <td>Samiec</td>
        <td>Samica</td>
        <td style="width:10%">Status</td>
        <td style="width:5%"></td>
    </tr>
@foreach ($data as $d)
    <tr>
        <td><a href="{{ route('litters.show', $d->id)}}">{{ $d->litter_code }}</a></td>
        <td>{{ $d->season }}</td>
        <td class="@if(!$d->connection_date) text-secondary @endif">{{ $d->connection_date ?? $d->planned_connection_date }}</td>
        <td><a href="{{ route('animal.profile', $d->parent_male)}}">{!! $d->animalMale->name !!}</td>
        <td><a href="{{ route('animal.profile', $d->parent_female)}}">{!! $d->animalFemale->name !!}</td>
        <td>{{ $litterRepo->litterStatus($d->id) }}</td>
        <td> </td>
</tr>
@endforeach
</table>

{{ $data->links() }}


