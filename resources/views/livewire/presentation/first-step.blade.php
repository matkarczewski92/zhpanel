<div class="text-center">
    <h5 class="mb-3">Wybierz rodzaj wyświetlanych danych</h5>
    <form >
        <input type="radio" class="btn-check" name="all" value="all" wire:model.live="presentationOption" id="option1" autocomplete="off">
        <label class="btn btn-outline-primary" for="option1">Wszystkie węże w hodowli</label>

        <input type="radio" class="btn-check" name="all" value="feed" wire:model.live="presentationOption" id="option2" autocomplete="off">
        <label class="btn btn-outline-primary ms-3" for="option2">Karmienia i Ważenia</label>

        <input type="radio" class="btn-check" name="all" value="litters" wire:model.live="presentationOption" id="option3" autocomplete="off">
        <label class="btn btn-outline-primary ms-3" for="option3">Mioty</label>


        @if ($animalCount!='')
            <h5 class="mt-5">Liczba zwierząt do wyświetlenia: {{ $animalCount}}</h5>
        @endif

        @if (!is_null($presentationOption) && $presentationOption==='litters')
            <div class="mt-5">
                <select class="form-select" wire:model.live="littersSelect">
                    <option value="">Wybierz miot</option>
                    @foreach ($litters as $lt)
                        <option value="{{$lt->id}}">{{$lt->litter_code}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ((!is_null($presentationOption) AND $presentationOption!='litters') OR ($presentationOption=='litters' AND $littersSelect!=''))
            <div class="d-grid gap-2 mt-5">
                <button class="btn btn-primary" type="button" wire:click="secondStep">Wyświetl prezentacje</button>
              </div>
        @endif


    </form>
</div>
