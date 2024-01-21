<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">

        <p class="text-center">{!! $animal->name !!}</p>
<table class="detailsTable" >
    <tr>
        <td class="key">Status</td>
        <td class="value">{{ $animal->animalCategory->name }}</td>
    </tr>
    <tr>
        <td class="key">Kategoria</td>
        <td class="value">{{ $animal->animalType->name }}</td>
    </tr>
    <tr>
        <td colspan="2"><div class="strike mb-2 mt-2"><span>Informacje ogónle</span></div></td>
    </tr>
    <tr>
        <td class="key">Płeć</td>
        <td class="value">{{ $animalRepo->sexName($animal->sex) }}</td>
    </tr>
    <tr>
        <td class="key">Data urodzenia</td>
        <td class="value">{{ $animal->date_of_birth }}</td>
    </tr>
    @if(!is_null($animal->litter_id))
    <tr>
        <td class="key">Miot</td>
        <td class="value">@if($animal->animalLitter->litter_code) {{ $animal->animalLitter?->litter_code }}@endif</td>
    </tr>
    @endif
    @if($animal->public_profile)
    <tr>
        <td class="key">Publiczny tag</td>
        <td class="value">{{ $animal?->public_profile_tag }}</td>
    </tr>
    @endif
    <tr>
        <td colspan="2"><div class="strike mb-2 mt-2"><span>Karmienie</span></div></td>
    </tr>
    <tr>
        <td class="key">Rodzaj karmy</td>
        <td class="value">{{ $animal->animalFeed?->name }}</a></td>
    </tr>
    <tr>
        <td class="key">Inrerwał karmienia</td>
        <td class="value">{{ $animalRepo->feedInterval($animal->id) }}</td>
    </tr>
    <tr>
        <td class="key">Data ost. karmienia</td>
        <td class="value">{{$animalRepo->lastFeed($animal->id)}}</td>
    </tr>
    <tr>
        <td class="key">Data nast. karmienia</td>
        <td class="value">{{$animalRepo->nextFeed($animal->id)}}</td>
    </tr>

</table>
   </div>
</div>
