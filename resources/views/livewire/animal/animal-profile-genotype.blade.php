<div>
    <div class="card mb-3 mt-4 bg-dark photobg rounded-1">
        @auth
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        @endauth
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Genetyka</span>
             </div>

             <div class="row mb-2">
                <div class="col-lg"><div class="strike mb-1 text-secondary"><span>Vis</span></div>
                    @foreach ($genotypeVis as $vis)
                    @if ($editMode == 1)
                    <a wire:click="delete({{$vis->id}})">{{$vis->genotypeCategory->name}}</a>,
                    @else
                    {{$vis->genotypeCategory->name}},
                    @endif
                    @endforeach

                </div>
                <div class="col-lg"><div class="strike mb-1 text-warning"><span>Het</span></div>
                    @foreach ($genotypeHet as $het)
                    @if ($editMode == 1)
                    <a wire:click="delete({{$het->id}})">{{$het->genotypeCategory->name}}</a>,
                    @else
                    {{$het->genotypeCategory->name}},
                    @endif
                    @endforeach

                </div>
                <div class="col-lg"><div class="strike mb-1 text-danger"><span>Poss</span></div>
                    @foreach ($genotypePos as $pos)
                    @if ($editMode == 1)
                    <a wire:click="delete({{$pos->id}})">{{$pos->genotypeCategory->name}}</a>,
                    @else
                    {{$pos->genotypeCategory->name}},
                    @endif
                    @endforeach
                </div>
            </div>
            @if ($editMode == 1)
            <form wire:submit="addGenotypeToProfile">
                <div class="input-group mt-5">
                    <span class="input-group-text" id="basic-addon1">Genotyp</span>
                    <input class="form-control" autoComplete="on" wire:model.live="name" list="suggestions"/>
                    <select class="form-select" wire:model="typeInput" required>
                        <option value="">Wybierz typ</option>
                        <option value="v">Vis</option>
                        <option value="h">Het</option>
                        <option value="p">Pos</option>
                    </select>
                    <button type="submit" class="btn btn-success" >Dodaj</button>
                    <div>
                        @if ($searchEng==1)
                        <datalist id="suggestions">
                            @foreach ($search as $s)
                            <option>{{$s['id']}}.{{$s['name']}}</option>
                            @endforeach
                        </datalist>
                        @endif
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>



</div>
