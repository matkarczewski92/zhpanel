@php
    $wColor = (session()->has('animalWeightColor')) ? session('animalWeightColor') : $weightIndicator;
    $fColor = (session()->has('animalFeedingColor')) ? session('animalFeedingColor') : $feedIndicator;
@endphp
<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">

        <div class="text-center mb-2">
            <form wire:submit="">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model="editNameInput">
                    <button type="button" class="btn btn-primary" wire:click="editName({{$actual->id}})">Zapisz</button>
                </div>
            </form>
        </div>

        <table class="detailsTable" >
            <tr>
                <td class="key">ID</td>
                <td class="value" colspan="2">{{ $actual->id }}</td>
            </tr>
            <tr>
                <td class="key">Płeć</td>
                <td class="value" colspan="2">
                    @if ($presentationOption == 'litters')
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" wire:model="editSexInput">
                            <option value="1">N/Sex</option>
                            <option value="2">Samiec</option>
                            <option value="3">Samica</option>
                        </select>
                        <button type="button" class="btn btn-primary" wire:click="editSex({{$actual->id}})">Zapisz</button>
                    </div>
                    @else
                    {{ $animalRepo->sexName($actual->sex) }}
                    @endif

                </td>
            </tr>
            <tr>
                <td class="key">Data urodzenia</td>
                <td class="value" colspan="2">{{ $actual->date_of_birth }}</td>
            </tr>
            @if(!is_null($actual->litter_id))
            <tr>
                <td class="key">Miot</td>
                <td class="value" colspan="2">@if($actual->animalLitter->litter_code) <a href="{{ route('litters.show', $actual->animalLitter->id) }} ">{{ $actual->animalLitter?->litter_code }}</a>@endif</td>
            </tr>
            @endif
            @if($actual->public_profile)
            <tr>
                <td class="key">Publiczny tag</td>
                <td class="value" colspan="2">{{ $actual?->public_profile_tag }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="3"><div class="strike mb-2 mt-2"><span>Karmienie</span></div></td>
            </tr>
            <tr>
                <td class="key {{$fColor}}">Rodzaj karmy</td>
                <td class="value {{$fColor}}">@if($actual?->feed_id)<a href="{{ route('feed.profile', $actual?->feed_id) }}">{{ $actual?->animalFeed->name }}</a>@endif</td>
                <td rowspan="4">@if(session()->has('animalFeedingColor'))<h3><i class="bi bi-check-square-fill text-success"> Dodano</i></h3>@endif</td>
            </tr>
            <tr>
                <td class="key {{$fColor}}">Inrerwał karmienia</td>
                <td class="value {{$fColor}}">co {{ $animalRepo->feedInterval($actual->id) }} dni</td>
            </tr>
            <tr>
                <td class="key {{$fColor}}">Data ost. karmienia</td>
                <td class="value {{$fColor}}">{{ $animalRepo->lastFeed($actual->id)}}</td>
            </tr>
            <tr class="">
                <td class="key {{$fColor}}">Data nast. karmienia</td>
                <td class="value {{$fColor}}">{{ $animalRepo->nextFeed($actual->id) }}</td>
            </tr>
            <tr>
                <td colspan="3"><div class="strike mb-2 mt-2"><span>Ważenia</span></div></td>
            </tr>
            <tr>
                <td class="key {{$wColor}}">Data ost. ważenie</td>
                <td class="value {{$wColor}}">{{ $animalRepo->lastWeighting($actual->id) }}</td>
                <td rowspan="2">@if(session()->has('animalWeightColor'))<h3><i class="bi bi-check-square-fill text-success"> Dodano</i></h3>@endif</td>
            </tr>
            <tr>
                <td class="key {{$wColor}}">Ostatnie ważenie</td>
                <td class="value {{$wColor}}">{{ $animalRepo->lastWeight($actual->id) }} g.</td>
            </tr>

        </table>
   </div>
</div>
