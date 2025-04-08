<div>
    <div class="card mb-3">
        <div class="card-header">Genetyka: Słownik Traitsów</div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td style="width:5%">Id</td>
                    <td style="width:10%">Ilosć genów</td>
                    <td>Nazwa</td>
                    <td>Składowe</td>

                </tr>
                @foreach ($traits as $trait)
                @php
                    $rowspan = ($trait->number_of_traits != 0) ? $trait->number_of_traits+1 : 2
                @endphp
                  <tr>
                    <td rowspan="{{$rowspan}}"><a href="#" wire:click="deleteTrait({{$trait->id}})"><i class="bi bi-trash3-fill"></i></a> {{$trait->id}}</td>
                    <td rowspan="{{$rowspan}}">{{$trait->number_of_traits}}</td>
                    <td rowspan="{{$rowspan}}">{{$trait->name}}</td>
                    <td>@if ($trait->number_of_traits != 0) <a href="#" wire:click="deleteTraitFromDictionary({{$trait->getTraitsDictionary->first()}})"><i class="bi bi-trash3-fill"></i></a>@endif {{$trait?->getTraitsDictionary->first()?->genotypeCategory->name ?? 'nie dodano'}}</td>
                </tr>  
                    @foreach ($trait->getTraitsDictionary->skip(1) as $ts)
                    <tr>
                        <td>
                            <a href="#" wire:click="deleteTraitFromDictionary({{$ts}})"><i class="bi bi-trash3-fill"></i></a> {{$ts->genotypeCategory->name}}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                            <form wire:submit="addToTraits({{ $trait->id }})">
                                <div class="input-group mt-2">
                                    <span class="input-group-text" id="basic-addon1">Dodaj gen</span>
                                    <select class="form-select" name="gensId" wire:model="gensId.{{$trait->id}}" >
                                        <option value="null"></option>
                                        @foreach ($gens as $g)
                                        @if (!in_array($g->name, $trait->getTraitsDictionary->pluck('genotypeCategory.name')->toArray()))
                                            <option value="{{$g->id}}">{{$g->name}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success" >Dodaj</button>
                                    <div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5">
                        <form wire:submit="addTrait()">
                        <div class="input-group mb-3 mt-3">
                            <input type="text" class="form-control" wire:model='traitName' required>
                            <button class="btn btn-outline-success" type="submit" id="button-addon2">Dodaj Trait</button>
                        </div> 
                        </form>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>
