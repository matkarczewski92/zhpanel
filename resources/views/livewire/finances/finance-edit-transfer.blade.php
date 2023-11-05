<div >


    <div class="strike mb-2">
        <span>Edycja transakcji</span>
    </div>
    <form wire:submit="edit({{$transferId}})">
        <div class="row">
        <div class="col">
            <div class="strike mb-2">
                <span>Dane podstawowe</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Rodzaj transakcji</span>
                <select class="form-select" wire:model="type" required>
                    <option value="i" @if ($type == 'i') selected @endif>Dochód</option>
                    <option value="c" @if ($type == 'c') selected @endif>Koszt</option>
                </select>

            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Tytuł </span>
                <input type="text" class="form-control" placeholder="Tytuł transacji"  wire:model="title" required>

            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Kategoria</span>
                <select class="form-select" aria-label="Default select example" wire:model="financesCategoryId" required>

                    @foreach ($financesCategory as $fC)
                    <option value="{{$fC->id}}" @if ($fC->id == $financesCategoryId) selected @endif>{{$fC->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Kwota</span>
                <input type="number" min="0.00" step="0.01" class="form-control" placeholder="Kwota" wire:model="amount" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Data</span>
                <input type="date" class="form-control"  wire:model="createdAt" required>
            </div>
        </div>
        <div class="col">
            <div class="strike mb-2">
                <span>Dane opcjonalne</span>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Karma</span>
                <select class="form-select"  wire:model="feedId">
                    <option value="" selected>Wybierz karme</option>
                    @foreach ($feeds as $fs)
                        <option value="{{$fs->id}}" @if ($fs->id == $feedId) selected @endif>{{$fs->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Zwierze</span>
                <select class="form-select"   wire:model="animalId">
                    <option value="" selected>Wybierz zwierze</option>
                    @foreach ($animals as $as)
                        <option value="{{$as->id}}" @if ($as->id == $animalId) selected @endif>#{{$as->id}} {!!$as->name!!}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
        <div class="d-grid gap-2">
            <button class="btn btn-success" type="submit">Zapisz</button>

        </div>

    </form>
    <hr/>
</div>
