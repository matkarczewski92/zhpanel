<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Zestawienie zwierząt</span>
         </div>
        <table class="detailsTable">
            <tr class="border-bottom">
                <td style="width: 10%">Id</td>
                <td>Zwierze</td>
                <td style="width: 15%">Interwał</td>

            </tr>
            {{-- {{dd($feed->animalFeed)}} --}}
            @foreach ($feed->animalsFeed as $aF)
            @php
                 $feedInterval = $animalRepo->feedInterval($aF->id);
            @endphp

            @if ($aF->animal_category_id !=5 AND $aF->animal_category_id !=3)
            <tr>
                <td>{{ $aF->id }} </td>
                <td><a href="{{ route('animal.profile', $aF->id)}}">{!! $aF->name !!}</a></td>
                <td>{{$feedInterval }} </td>
            </tr>
            @endif

            @endforeach

        </table>
    </div>
</div>
