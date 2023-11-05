<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Kategorie</span>
            </div>
            @if (session()->has('financesCategory'))
            <div class="alert alert-{{ session('financesCategoryColor') }} alert-dismissible fade show" role="alert">
                {{ session('financesCategory') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <table class="detailsTable">
                <tr>
                    <td style="width: 15%">Id</td>
                    <td>Nazwa</td>
                    <td style="width: 15%"></td>
                </tr>
                @foreach ($financesCategory as $ac)
                    @if ($editId == $ac->id)
                        <tr>
                            <td>
                                <form>
                                    <div>
                                        <input type="hidden" class="form-control" wire:model="editId" required>
                                        {{$ac->id}}
                                        {{-- <input type="text" class="form-control" wire:model="editIdNew" required> --}}
                            </td>
                            <td>
                                <input type="text" class="form-control" wire:model="editName" required>
                            </td>
                            <td>
                                <div class="input-group">

                                    <button class="btn btn-success" type="submit" id="button-addon2"
                                        wire:click="update">Zapisz</button>
                                </div>


                            </td>

                            </form>
                        </tr>
                    @else
                        <tr>
                            <td style="width: 10%">{{ $ac->id }}</td>
                            <td> {{ $ac->name }}</td>
                            <td style="width: 10%" >
                                <a href="#" wire:click.prevent="editShow({{ $ac->id }})"><i class="fa-solid fa-pen-to-square fa-lg me-2"></i></a>
                                @if ($ac->id > 5)
                                <a href="#" wire:click.prevent="delete({{ $ac->id }})"><i class="fa-solid fa-trash"></i></a>
                                @endif

                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
            <form wire:submit="store" class="mt-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Podaj nazwe kategorii" wire:model="name"
                        required>
                    <button class="btn btn-success" type="submit" id="button-addon2">Dodaj</button>
                </div>
            </form>


        </div>
    </div>
</div>
