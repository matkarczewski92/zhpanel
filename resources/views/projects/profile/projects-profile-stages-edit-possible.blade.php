@if (!is_null($litter))

@php
    if($litter->where('category', 1)->where('season', $stage->season)->first())
        {
            $litterData = $litter->where('category', 1)->where('season', $stage->season)->first()?->getPossibleOffspring;
        } elseif ($litter->where('category', 2)->where('season', $stage->season)->first()) {
            $litterData = $litter->where('category', 2)->where('season', $stage->season)->first()?->getPossibleOffsprin;
        } else {
            $litterData = $litter->where('category', 3)->where('season', null)->first()?->getPossibleOffspring;
        }
@endphp
    <div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span class="h4">Dostępne łączenia</span>
            </div>
            <table class="tdetailsTable text-light w-100">
                <tr>
                    <td style="width:5%">%</td>
                    <td>Nazwa</td>
                    <td>Miot</td>
                    <td  style="width:5%"></td>

                </tr>
            @foreach ($litterData ?? [] as $pO)
                <tr>
                    <td>{{$pO->percent}} %</td>
                    <td>{{$pO->title_vis}} - {{$pO->title_het}}</td>
                    <td><a href="{{ route('litters.show', $pO->litter_id) }}">{{$pO->litter_id}} - {{$pO->litterDetails?->litter_code}}</td>
                    <td></td>
                </tr>


            @endforeach
            </table>
        </div>
    </div>
@endif
{{--  --}}
