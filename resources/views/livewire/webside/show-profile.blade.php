<div>
    <div class="input-group mb-3 mt-5">
        <span class="input-group-text" id="basic-addon1">Podaj KOD węża</span>
        <input type="text" class="form-control" wire:model="animalToken">
        <button type="button" class="btn btn-light" wire:click="checkToken()">WYŚWIETL PROFIL</button>
    </div>
    @if (!empty($animalId))
    <div class="row mb-4">
        <div class="col">
            <div class="card bg-dark photobg rounded-1" >
                <div class="text-center">
                        <h5 class="m-2">{!!$animal->name!!}</h5>
                </div>
            </div>
        </div>
    </div>
        <div class="row ms-2 me-1 mb-5">
            <div class="col ">
                <div class="row">
                    <div class="col-lg">

                         @include('livewire.webside.components.gallery')
                         @include('livewire.webside.components.details')
                         {{-- @include('livewire.webside.components.genotype') --}}

                    </div>
                    <div class="col-lg-6">

                        @include('livewire.webside.components.feedings')



                    </div>
                    <div class="col-lg">
                        @include('livewire.webside.components.weight')
                        @include('livewire.webside.components.molts')
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
