<div>
    <div class="card mb-3">
        <div class="card-header">Profil zwierząt: Typ</div>
        <div class="card-body">
            @if (session()->has('settingsAnimalTypeMsg'))
            <div class="alert alert-{{ session('settingsAnimalTypeMsgColor') }} alert-dismissible fade show" role="alert">
                {{ session('settingsAnimalTypeMsg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <table class="table">
                <tr>
                    <td style="width:15%">Id</td>
                    <td>Nazwa</td>
                    <td>Opcje</td>
                </tr>
                @foreach ($animalType as $ac)
                    @if ($editId == $ac->id)
                    <tr>
                        <td >
                            <form wire:submit>
                                <input type="hidden" class="form-control"  wire:model="editId" required>
                                <input type="text" class="form-control"  wire:model="editIdNew" required>
                        </td>
                        <td colspan="3">
                                <div class="input-group">

                                    <input type="text" class="form-control" wire:model="editName" >
                                    <button class="btn btn-success" type="submit" wire:click="editSave">Zapisz</button>
                                </div>
                            </form>
                            <sub class="text-danger">W celu usunięcia pozycji podczas edycji pozostaw pole puste</sub>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td style="width: 10%">{{ $ac->id }}</td>
                        <td> {{ $ac->name }}</td>
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
