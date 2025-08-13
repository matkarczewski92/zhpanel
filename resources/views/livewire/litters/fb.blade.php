<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body">
        <div class="strike mb-2">
            <span class="text-white fw-bold">Dodaj post na FB ze zdjęciami maluchów</span>
        </div>

        <form wire:submit.prevent="save" class="h-100 d-flex flex-column">
            <div class="mb-3 flex-grow-1">
                <textarea 
                    class="form-control adnotations h-100" 
                    wire:model.defer="adnotation" 
                    placeholder="Napisz treść posta..."
                    rows="5"
                ></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Publikuj
            </button>
        </form>

        @if($status)
            <div class="alert alert-secondary mt-3 mb-0">
                <div class="small text-break">
                    <pre class="mb-0" style="white-space: pre-wrap;">{{ $status }}</pre>
                </div>
            </div>
        @endif
    </div>
</div>
