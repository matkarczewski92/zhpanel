<div>
    <div class="card mb-3">
        <div class="card-header">Profil zwierząt: Genotyp - kategorie</div>
        <div class="card-body">
            @if (session()->has('settingsAnimalGenotypeMsg'))
            <div class="alert alert-{{ session('settingsAnimalGenotypeMsgColor') }} alert-dismissible fade show" role="alert">
                {{ session('settingsAnimalGenotypeMsg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <table class="table">
                <tr>
                    <td>Id</td>
                    <td>Nazwa</td>
                    <td>Kod</td>
                    <td>Opcje</td>
                </tr>
                @foreach ($animalGenotype as $ac)
                    @if ($editId == $ac->id)
                    <tr>
                        <td>
                            <form>
                            <div>
                                    <input type="hidden" class="form-control"  wire:model="editId" required>
                                    <input type="text" class="form-control"  wire:model="editIdNew" required>
                        </td>
                        <td colspan="2">
                            <input type="text" class="form-control" wire:model="editName" >
                        </td>
                        <td>
                                <div class="input-group">

                                    <button class="btn btn-success" type="submit" id="button-addon2" wire:click="editSave" >Zapisz</button>
                                </div>


                        </td>

                    </form>
                    </tr>
                    @else
                    <tr>
                        <td style="width: 10%">{{ $ac->id }}</td>
                        <td> {{ $ac->name }}</td>
                        <td> {{ $ac->code }}</td>
                            <td style="width: 10%" class="text-center" >
                            <a href="#" wire:click.prevent="editShow({{ $ac->id }})"><i class="fa-solid fa-pen-to-square fa-lg me-2"></i></a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </table>
            <form wire:submit="save">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Podaj nazwe kategorii" wire:model="name" required>
                    <button class="btn btn-success" type="submit" id="button-addon2">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</div>
