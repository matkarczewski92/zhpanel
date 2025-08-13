<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        <button type="button" wire:click="save()" class="btn btn-success rounded-circle editmode">
            <i class="fa-regular fa-floppy-disk fa-lg"></i>
        </button>
        <div class="strike mb-2">
            <span>Publikuj post na FB</span>
         </div>
         <textarea class="adnotations h-75" wire:model="adnotation"></textarea>
         {{-- @if ($status == 'ok')
         <p class="text-center text-success">Zapisano pomyślnie</p>
        @endif --}}
    </div>
</div>

 