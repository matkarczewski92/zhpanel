    <div class="card mb-3 bg-dark photobg rounded-1  h-100">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Dodaj transakcje</span>
            </div>
            @if (session()->has('transactionCreate'))
            <div class="alert alert-{{ session('transactionCreateColor') }} alert-dismissible fade show" role="alert">
                {{ session('transactionCreate') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           @endif
           @error('type') <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@enderror
           @error('financesCategoryId') <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@enderror

            <form wire:submit="create">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:30%">Rodzaj transakcji</span>
                    <select class="form-select" wire:model="type" required>
                        <option selected>Wybierz rodzaj transakcji</option>
                        <option value="i">Dochód</option>
                        <option value="c">Koszt</option>
                    </select>

                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:30%">Tytuł </span>
                    <input type="text" class="form-control" placeholder="Tytuł transacji"  wire:model="title" required>

                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:30%">Kategoria</span>
                    <select class="form-select" aria-label="Default select example" wire:model="financesCategoryId" required>
                        <option selected>Wybierz kategorie</option>
                        @foreach ($financesCategory as $fC)
                        <option value="{{$fC->id}}">{{$fC->name}}</option>
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

                <div class="strike mb-2">
                    <span>Dane opcjonalne</span>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:30%">Karma</span>
                    <select class="form-select"  wire:model="feedId">
                        <option selected>Wybierz karme</option>
                        @foreach ($feeds as $fs)
                            <option value="{{$fs->id}}">{{$fs->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:30%">Zwierze</span>
                    <select class="form-select"   wire:model="animalId">
                        <option selected>Wybierz zwierze</option>
                        @foreach ($animals as $as)
                            <option value="{{$as->id}}">#{{$as->id}} {!!$as->name!!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">Dodaj</button>
                </div>

            </form>
        </div>
    </div>

