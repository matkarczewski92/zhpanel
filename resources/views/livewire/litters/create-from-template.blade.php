<div>

    <div class="modal-header">
        <h1 class="modal-title fs-5" id="addFromTemplate">Dodaj miot z szablonu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <div class="input-group mb-3">
            <span class="input-group-text">Samica</span>
            <select class="form-select" wire:model.live="female">
                <option value="">Wybierz samice</option>
                @foreach ($females as $f)
                    <option value="{{$f->id}}">{!! $f->name !!}</option>
                @endforeach
            </select>
        </div>

        @if (!empty($female))
        <div class="input-group mb-3">
            <span class="input-group-text">Samiec</span>
            <select class="form-select" wire:model.live="male">
                <option value="">Wybierz samice</option>
                @foreach ($males as $m)
                    <option value="{{$m->id}}">{!! $m->name !!}</option>
                @endforeach
            </select>
        </div>
        {{ $stepTwo }}
        @endif
        @if (!empty($list))
        <div class="input-group mb-3">
            <span class="input-group-text">Samiec</span>
            <select class="form-select" wire:model.live="litterId">
                <option value="">Wybierz szablon</option>
                @foreach ($list as $l)
                        <option value="{{$l->id}}">{{$l->litter_code}}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
        @if (!empty($litterId))
        <button type="submit" class="btn btn-primary" wire:click="createLitter()">Dodaj</button>
        @endif


    </div>
</div>
