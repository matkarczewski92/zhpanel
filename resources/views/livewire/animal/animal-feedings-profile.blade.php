<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Karmienie</span>
             </div>
            @if (session()->has('animalFeeding'))
             <div class="alert alert-{{ session('animalFeedingColor') }} alert-dismissible fade show" role="alert">
                 {{ session('animalFeeding') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            @endif
            @if (!empty($feedings))

            <table class="detailsTable">
                    <tr>
                        <td style="width:10%">Rok</td>
                        <td style="width:10%" class="" id="miesiac">Miesiąc</td>
                        <td style="width:20%" class="" id="data">Data karmienia</td>
                        <td>Rodzaj karmy</td>
                        <td style="width: 10%" >Ilość</td>
                        <td style="width: 5%"></td>
                    </tr>
            @foreach ($feedings as $one => $value)
                    <tr class="border-bottom">
                        <td colspan="6"><a data-bs-toggle="collapse" href="#{{$one}}" onclick="myFunction('miesiac')">{{$one}} <i class="fa-solid fa-caret-down fa-sm"></i></a></td>
                    </tr>
                @foreach ($value as $two => $value)
                    @foreach ($value as $three => $value)
                    <tbody class="collapse" id="{{$one}}">
                        <tr>
                            <td style="width:5%"></td>
                            <td colspan="5"><a data-bs-toggle="collapse" href="#{{$two}}" onclick="myFunction('data')">{{$two}} <i class="fa-solid fa-caret-down fa-sm"></i></a></td>
                        </tr>
                        @foreach ($value as $four)
                            <tr class="collapse " id="{{$two}}">
                                <td></td>
                                <td></td>
                                <td>{{$four->created_at->format("Y-m-d")}}</td>
                                <td>{{$four->feedType?->name}}</td>
                                <td>{{$four->amount}}</td>
                                <td style="width:5%">
                                <button class="btn btn-sm" type="submit" wire:click="delete({{$four->id}})"> <i class="fa-regular fa-trash-can"></i></button></td>
                                   </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endforeach
                @endforeach
            @endforeach

        </table>
        @else
        <div class="alert alert-warning" role="alert">
            Nie dodano jeszcze żadnego karmienia
        </div>
        @endif
        @if ($editMode == 1)
            <div class="mt-4">
                    <form wire:submit="store">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Dodaj karmienie</span>
                    <select class="form-select" wire:model="feed_id" required>
                        @foreach ($feeds as $fs)
                        @if ($fs->amount >0 )
                        <option value="{{$fs->id}}" @if($animal->feed_id == $fs->id) selected @endif>{{$fs->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="number" min="0" wire:model="amount" class="form-control" placeholder="Ilość" required>
                    <input type="date"  wire:model="date" class="form-control" required>
                    <input type="hidden" wire:model="animal_id" value="{{$animalId}}" class="form-control" placeholder="Ilość">
                    <button type="submit" class="btn btn-success">Dodaj</button>
                    </form>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
