<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Możliwe potomstwo</span>
         </div>

         <div class="row">
            <div class="col-lg-2">
                <label class="border-bottom w-100 text-center mb-1" style="width:20%">Kategoria</label>
                <div class="input-group mb-3">
                    <select class="form-select " size="8" multiple wire:model.live="filterCategory">
                        <option value="all">Wszystkie</option>
                        <option value="1">Miot</option>
                        <option value="2">Planowane</option>
                        <option value="3">Szablon</option>
                        <option value="4">Zakończone</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="border-bottom w-100 text-center mb-1" style="width:20%">Sezon</label>
                <div class="input-group mb-3">
                    <select class="form-select " size="8" multiple wire:model.live="filterSeason">
                        <option value="all">Wszystkie</option>
                        @foreach ($seasons as $ss)
                        <option value="{{$ss[0]->season}}">{{$ss[0]->season}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="border-bottom w-100 text-center mb-1" style="width:20%">Vis</label>
                <div class="input-group mb-3">
                    <select class="form-select " size="8" multiple wire:model.live="filterVis">
                        <option value="all">Wszystkie</option>
                        @foreach ($genCategory as $gC)
                        <option value="{{$gC->name}}">{{$gC->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="border-bottom w-100 text-center mb-1" style="width:20%">Het</label>
                <div class="input-group mb-3">
                    <select class="form-select " size="8" multiple wire:model.live="filterHet">
                        <option value="all">Wszystkie</option>
                        @foreach ($genCategory as $gC)
                        <option value="{{$gC->name}}">{{$gC->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="input-group mb-">
                    <label class="border-bottom w-100 text-center mb-1" style="width:20%">Nazwa VIS</label>
                    <input type="text" wire:model.live="visHelper" class="form-control">
                </div>

                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" role="switch" wire:model.live="posscheck">
                    <label class="form-check-label" for="flexSwitchCheckDefault">PossCheck</label>
                  </div>
            </div>
         </div>


        <table class="detailsTable">
            <tr class="border-bottom">
                <td style="width:15%">Kod Miotu</td>
                <td style="width:10%">Kategoria</td>
                <td style="width:5%" class="border-end">Sezon</td>
                <td class="text-center" style="width:5%">Procent</td>
                <td>Vis</td>
                <td>Het</td>
                {{-- <td class="text-center border-start" style="width: 10%">Opcje</td> --}}
            </tr>
            @foreach ($offspring ?? [] as $of)
            <tr>
                <td><a href="{{ route('litters.show', $of->litter_id) }}">{{ $of->litterDetails->litter_code }}</a></td>
                <td><a href="{{ route('litters.show', $of->litter_id) }}">{{ $litterRepo->litterCategory($of->litterDetails->category) }}</a></td>
                <td class="border-end"><a href="{{ route('litters.show', $of->litter_id) }}">{{ $of->litterDetails?->season }}</a></td>
                <td class="text-center">{{ $of->percent }} %</td>
                <td>{{ $of->title_vis }}</td>
                <td>{{ $of->title_het }}</td>
                {{-- <td class="border-start">
                    <i class="fa-solid fa-mars "></i>
                    <i class="fa-solid fa-venus "></i>
                </td> --}}
            </tr>
            @endforeach

        </table>
    </div>
</div>
