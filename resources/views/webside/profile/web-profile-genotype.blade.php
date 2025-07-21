<div>
    <div class="card mb-3 mt-4 bg-dark photobg rounded-1">
        @auth
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        @endauth
        <div class="card-body " style="">
            <div class="col m-1 ">
                <div class="strike mb-2 mt-2 me-1"><span>Genetyka</span></div>
            </div>
        </div>
        <div class="row">
            <div class="col ms-3">
            <p>
                @php
                    $sortedGenotypes = $animal->animalGenotype->sortBy(function($item) {
                    return match($item->type) {
                            'v' => 0,
                            'h' => 1,
                            default => 2,
                        };
                    });
                @endphp
                @foreach ($sortedGenotypes as $genotype)
                    @php
                        if(ctype_upper($genotype->genotypeCategory->gene_code)){
                            $color = "text-bg-danger";
                            $tooltip = "Dominant";
                        } elseif($genotype->type == "v") {
                            $color = "text-bg-success";
                            $tooltip = "Homozygota - wizualny";
                        } elseif($genotype->type == "h") {
                            $color = "text-bg-primary";
                            $tooltip = "Heterozygota";
                        } else {
                            $color = "text-bg-secondary";
                            $tooltip = "Possible het.";
                        }
                    @endphp
                    @if ($editMode == 1)
                    <a wire:click="delete({{$genotype->id}})">
                        <span class="badge {{$color}}" data-bs-toggle="tooltip" data-bs-title="{{$tooltip}}" style="font-size: 10pt;">{{$genotype->genotypeCategory->name}}</span>
                    </a>
                    @else
                    <span class="badge {{$color}}" data-bs-toggle="tooltip" data-bs-title="{{$tooltip}}" style="font-size: 10pt;">{{$genotype->genotypeCategory->name}}</span>
                    @endif
                @endforeach
            </p>
        </div> 
            @if ($editMode == 1)
            <form wire:submit="addGenotypeToProfile">
                <div class="input-group mt-2">
                    <span class="input-group-text" id="basic-addon1">Genotyp</span>
                    <input class="form-control" autoComplete="on" wire:model.live="name" list="suggestions"/>
                    <select class="form-select" wire:model="typeInput" required>
                        <option value="">Wybierz typ</option>
                        <option value="v">Vis</option>
                        <option value="h">Het</option>
                        <option value="p">Pos</option>
                    </select>
                    <button type="submit" class="btn btn-success" >Dodaj</button>
                    <div>
                        @if ($searchEng==1)
                        <datalist id="suggestions">
                            @foreach ($search as $s)
                            <option>{{$s['id']}}.{{$s['name']}}</option>
                            @endforeach
                        </datalist>
                        @endif
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
