
<div class="strike">
    <span>Karmienie</span>
</div>
<div class="mt-4 ">
    <form wire:submit="storeFeed">
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Dodaj karmienie</span>
        <select class="form-select" wire:model="feed_id" required>
            <option value="">Wybierz karmę</option>
            @foreach ($feeds as $fs)
                @if ($fs->amount >0 )
                    <option value="{{$fs->id}}" @if($actual->feed_id == $fs->id) selected @endif>{{$fs->name}}</option>
                @endif
            @endforeach
        </select>
            <input type="number" min="0" wire:model="amount" class="form-control" placeholder="Ilość" required>
            <input type="date"  wire:model="date" class="form-control" required>
            <input type="hidden" wire:model="animal_id" value="{{$actual->id}}" class="form-control" placeholder="Ilość">
            <button type="submit" class="btn btn-success">Dodaj</button>
        </div>
    </form>
</div>
