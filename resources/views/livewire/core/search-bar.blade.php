<div>
    <div class="input-group">
        <select class="form-select"
            wire:model.live="category"
            wire:model.change="category"
        >
            <option value="">Wszystkie</option>
            <option value="H">W hodowli</option>
            <option value="S">Sprzedane</option>
            <option value="N">Na sprzedaż</option>
            <option value="M">Mioty</option>

        </select>
        <input
            type="text"
            class="input-group-text"
            placeholder="Wyszukaj"
            wire:model.live="query"
            wire:keydown.escape="resetData"
            wire:keydown.arrow-up="decrementHighlight"
            wire:keydown.arrow-down="incrementHighlight"
            wire:keydown.enter="selectContact"
        />
    </div>
    <div wire:loading class="position-absolute z-10 w-full bg-dark rounded-t-none shadow-lg list-group">
        <div class="list-item">Szukanie...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetData"></div>

        <div style="width:35%; margin-left: -15%">
            <div class="position-absolute bg-dark w-full rounded-t-none shadow-lg list-group me-3" >
                @if(!empty($contacts))
                    @foreach($contacts as $i => $contact)
                        <a
                            href="{{ route('animal.profile', $contact['id']) }}"
                            class="list-item {{ $highlightIndex === $i ? 'text-bg-light' : '' }} me-2 ms-2"
                        >{!! $contact['name'] ?? $contact['litter_code'] !!}</a>
                    @endforeach
                @else
                    <div class="list-item">Brak wyników</div>
                @endif
            </div>
        </div>
    @endif
</div>
