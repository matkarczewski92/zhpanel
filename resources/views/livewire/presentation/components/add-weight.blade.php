<div class="strike">
    <span>Ważenie</span>
</div>

<form wire:submit="addWeight">
    <div class="input-group">
        <span class="input-group-text" id="basic-addon1">Podaj wagę</span>
        <input type="number" class="form-control" wire:model="inputWeight" required>
        <input type="date" class="form-control" wire:model="inputDate" >
        <button type="submit" class="btn btn-success" >Dodaj</button>
    </div>
</form>
