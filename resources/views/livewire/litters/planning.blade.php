<div class="card bg-dark photobg rounded-1">
    <div class="card-body" style="">
        <div class="strike mb-2">
            <span>Planowanie</span>
         </div>
         <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1" style="width: 30%">Data łączenia</span>
            <input type="date" class="form-control" wire:model="connectionDate" wire:change="change('c')">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1" style="width: 30%">Data zniosu</span>
            <input type="date" class="form-control" wire:model="layingDate" wire:change="change('l')">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1" style="width: 30%">Data wyklucia</span>
            <input type="date" class="form-control" wire:model="hatchlingDate" wire:change="change('h')">
          </div>
    </div>
</div>
