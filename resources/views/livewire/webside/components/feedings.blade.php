<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Karmienie</span>
             </div>
            @if (!empty($animal->animalFeedings))
             {{-- {{ dd($animal->animalFeedings) }} --}}
            <table class="detailsTable">
                    <tr>
                        <td style="width:20%" class="" id="data">Data karmienia</td>
                        <td>Rodzaj karmy</td>
                        <td style="width: 10%" >Ilość</td>
                        <td style="width: 5%"></td>
                    </tr>
            @foreach ($animal->animalFeedings as $fd)
                    <tr>
                        <td>{{$fd->created_at->format("Y-m-d")}}</td>
                        <td>{{$fd->feedType->name}}</td>
                        <td>{{$fd->amount}}</td>
                    </tr>
            @endforeach

        </table>
        @else
        <div class="alert alert-warning" role="alert">
            Nie dodano jeszcze żadnego karmienia
        </div>
        @endif
        </div>
    </div>
</div>
