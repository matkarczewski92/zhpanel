@if ($step == 2)
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="btn-group" role="group" >
                <button type="button" class="btn btn-danger"  @if ($index >= 1) wire:click="prevStep" @else disabled @endif>Poprzedni</button>
                <button type="button" class="btn btn-warning" wire:click="endPres">Zakończ</button>
                <button type="button" class="btn btn-success"  @if ($animalCount > $index+1) wire:click="nextStep" @else disabled @endif>Następny</button>
            </div>
        </div>
    </div>
    @endif
