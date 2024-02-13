<div class="card mb-3">
    <div class="card-header">Konfiguracja systemu</div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <table class="detailsTable mb-3">
            <tr class="border-bottom">
                <td>Klucz</td>
                <td>Nazwa</td>
                <td>Wartość</td>
                <td></td>
            </tr>
            @foreach ($settings as $set)
            <tr class="border-bottom">
                <td>{{$set->key}}</td>
                <td>@if ($editId === $set->id) <input type="text" class="form-control" wire:model="editName"> @else {{$set->name}} @endif</td>
                <td class="w-25"  style="word-wrap: break-word; white-space: normal !important; min-width: 70px;max-width: 70px;">@if ($editId === $set->id)
                    <div class="input-group ">
                        <input type="text" wire:model="editValue" class="form-control">
                        <button class="btn btn-success" wire:click="update({{$set->id}})"><i class="fa-regular fa-floppy-disk"></i></button>
                    </div>
                    @else {{$set->value}} @endif</td>
                <td><a href="#" wire:click.prevent="editShow({{ $set->id }})"><i class="fa-solid fa-pen-to-square fa-lg me-2"></i></a></td>
            </tr>
            @endforeach
        </table>
        @error('key')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @error('name')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @error('value')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror


        <div class="input-group mb-3 mt-3">
            <input type="text" class="form-control" placeholder="Podaj nazwe klucza" wire:model="key" required>
            <input type="text" class="form-control" placeholder="Podaj nazwe" wire:model="name" required>
            <input type="text" class="form-control" placeholder="Podaj wartość" wire:model="value" required>
            <button class="btn btn-success" type="submit" wire:click="addConfig()">Dodaj</button>
        </div>
    </div>
</div>
