<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Do zatrzymania w hodowli</span>
         </div>
        <table class="tdetailsTable text-light w-100" id="animalTable" data-page-length='50'>
            <thead>
                <tr>
                    <td style="width:5%">Id</td>
                    <td style="width:10%">Kod miotu</td>
                    <td style="width:20%">Vis</td>
                    <td style="width:20%">Het</td>
                    <td style="width:30%">Adnotacja</td>
                    <td>Sezon</td>
                    <td>Płeć</td>
                    <td style="width:3%"> </td>
                </tr>
            </thead>
            <tbody >

                @foreach ($animal ?? [] as $an)
                @php
                $sex = $animalRepo->sexName($an->sex);
                @endphp
                <tr >
                    <td>{{$an->id}}</td>
                    <td><a href="{{ route('litters.show', $an->pairingDetails->litterDetails->id)}}">{{$an->pairingDetails->litterDetails->litter_code}}</a></td>
                    <td>{{$an->pairingDetails->title_vis}}</td>
                    <td>{{$an->pairingDetails->title_het}}</td>
                    <td>{{$an->annotations}}</td>
                    <td>{{$an->pairingDetails->litterDetails->season}}</td>
                    <td>{{ $sex }}</td>
                    <td>
                        <form id="destroy-form" action="{{ route('not-for-sale.destroy', $an->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
