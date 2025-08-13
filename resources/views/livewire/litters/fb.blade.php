<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body">

        {{-- LOADER przy wysyłaniu --}}
        <div wire:loading.inline>
            <div class="alert alert-secondary mb-3">
                Wysyłanie… Proszę czekać.
            </div>
        </div>

        {{-- JEŚLI NIE WYSŁANO – FORMULARZ --}}
        @unless($submitted)
            <div class="strike mb-2"><span>Publikuj post na FB</span></div>

            <textarea class="adnotations form-control mb-3"
                      rows="8"
                      wire:model.defer="adnotation"></textarea>

            <button type="button"
                    wire:click="save"
                    wire:loading.attr="disabled"
                    class="btn btn-primary">
                Zapisz i wyślij
            </button>
        @endunless

        {{-- JEŚLI WYSŁANO – PODSUMOWANIE --}}
        @if($submitted)
            @if($apiOk)
                <div class="alert alert-success">
                    <strong>Wysłano!</strong> Post został opublikowany.
                </div>

                @if($apiPayload)
                    <div class="card bg-black border-secondary mb-3">
                        <div class="card-header">Odpowiedź API</div>
                        <div class="card-body">
<pre class="mb-0 text-light" style="white-space: pre-wrap;">{{ json_encode($apiPayload, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-danger">
                    <strong>Błąd!</strong> {{ $error ?? 'Nieznany błąd.' }}
                </div>
            @endif

            <button type="button" class="btn btn-outline-light" wire:click="resetForm">
                Wyślij kolejny post
            </button>
        @endif
    </div>
</div>
