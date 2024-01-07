<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Dodaj NFS</span>
        </div>
        <form wire:submit="addNfs">
            <select name="litter" wire:model.live="litter" class="form-select">
                <option value="">Wybierz miot</option>

                @foreach ($litters as $lt)

                <option value="{{$lt->id}}">{{litterCategory($lt->category)}} - {{$lt->litter_code}} : {!! $lt->litterDetails->animalMale->name !!} &nbsp;&nbsp;&nbsp;&nbsp; X &nbsp;&nbsp;&nbsp;&nbsp; {!! $lt->litterDetails->animalFemale->name !!}</option>
                @endforeach
            </select>

            @if (!empty($litter))
            <select name="litter" wire:model.live="animal" class="form-select mt-3">
                <option value="">Wybierz miot</option>
                @foreach ($animals as $lt)
                <option value="{{$lt->id}}">{{litterCategory($lt->category)}} - {{$lt->litter_code}} : {{ $lt->title_vis }} - {{ $lt->title_het }} - </option>
                @endforeach
            </select>
            @endif
            @if (!empty($animal))
            <select name="litter" wire:model.live="sex" class="form-select mt-3">
                <option value="">Wybierz płeć</option>
                <option value="2">Samiec</option>
                <option value="3">Samica</option>
            </select>
            @endif
            @if (!empty($sex))
            <div class="input-group mt-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Adnotacja:</span>
                <input type="text" class="form-control" wire:model="annotations">
              </div>
            <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary" type="submit">Dodaj</button>
              </div>
            @endif
        </form>
    </div>
</div>
