<div class="modal fade" id="addLitter" tabindex="-1" aria-labelledby="addLitter" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addLitter">Dodaj miot</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('litters.store')}}" method="post">
                    @csrf <!-- {{ csrf_field() }} -->

                    <div class="input-group mb-3">
                        <span class="input-group-text" >Rodzaj miotu</span>
                        <select class="form-select" name="category" >
                            <option value="2" @if(isset($part) and $part == "availableconnections") disabled @endif>Planowany</option>
                            <option value="1" @if(isset($part) and $part == "availableconnections") disabled @endif>Miot</option>
                            <option value="3" @if(isset($part) and $part == "availableconnections") selected @endif>Szablon</option>
                            <option value="4" @if(isset($part) and $part == "availableconnections") disabled @endif>Zrealizowany</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"> @if(!isset($part)) Kod miotu @else Nazwa szablonu @endif</span>
                        <input type="text" class="form-control" name="litter_code" required>
                    </div>
                    @if(!isset($part))

                    <div class="input-group mb-3">
                        <span class="input-group-text">Sezon</span>
                        <input type="number" min="0" class="form-control" name="season">
                    </div>
                    @endif
                    <div class="input-group mb-3">
                        <span class="input-group-text">Samiec</span>
                        <select class="form-select" name="parent_male">
                            @foreach ($animalsMale as $aM)
                            <option value="{{$aM->id}}">{!!$aM->name!!}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" >Samica</span>
                        <select class="form-select" name="parent_female">
                            @foreach ($animalsFemale as $aF)
                            <option value="{{$aF->id}}">{!!$aF->name!!}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </div>
        </form>
        </div>
    </div>
</div>





