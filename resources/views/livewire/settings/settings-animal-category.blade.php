<div>
    <div class="card mb-3">
        <div class="card-header">Profil zwierząt: Kategoria</div>
        <div class="card-body">
            @if (session()->has('settingsAnimalCategoryMsg'))
            <div class="alert alert-{{ session('settingsAnimalCategoryMsgColor') }} alert-dismissible fade show" role="alert">
                {{ session('settingsAnimalCategoryMsg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <table class="table">
                <tr>
                    <td>Id</td>
                    <td>Nazwa</td>
                    <td>Opcje</td>
                </tr>
                @foreach ($animalCategory as $ac)
                    @if ($editId == $ac->id)
                    <tr>
                        <td colspan="3">
                            <form wire:submit="editSave">
                                <div class="input-group">
                                    <input type="hidden" class="form-control"  wire:model="editId" required>
                                    <input type="text" class="form-control" wire:model="editName" required>
                                    <button class="btn btn-success" type="submit" id="button-addon2">Zapisz</button>
                                </div>
                            </form>

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
