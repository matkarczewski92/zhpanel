<div class="card mb-3">
    <div class="card-header">Zimowanie - etapy</div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <tr>
                <td>Kolejność</td>
                <td>Nazwa</td>
                <td>Czas trwania</td>
                <td></td>
            </tr>
            @foreach ($winteringsStages as $stage)
            <tr>

            @if ($stagesEditId != $stage->id)
                <td style="width:15%">{{ $stage->order }}</td>
                <td>{{ $stage->title }}</td>
                <td>{{ $stage->duration }} dni</td>
                <td> <a href="#" wire:click.prevent="editShow({{ $stage->id }})"><i class="fa-solid fa-pen-to-square fa-lg me-2"></i></a></td>
            @else
            <form wire:submit>
                <td>
                    <input type="number" class="form-control" wire:model="order">
                </td>
                <td>
                    <input type="text" class="form-control" wire:model="title">
                </td>
                <td colspan="2">
                    <div class="input-group">
                        <input type="number" class="form-control" wire:model="duration">
                        <button class="btn btn-success" type="submit" wire:click="editSave">Zapisz</button>
                        <button class="btn btn-danger" type="submit" wire:click="delete">Usuń</button>
                    </div>
                    </td>
            </tr>
            </form>
            @endif
            @endforeach
            <tr>
                <td colspan="4" class="text-end">Łącznie: {{ $winteringsStages->sum('duration') }} dni</td>
            </tr>
            </table>
            <form wire:submit="create">
                    <div class="input-group">
                        <input type="number" class="form-control" wire:model="newOrder" placeholder="Kolejność" required>
                        <input type="text" class="form-control" wire:model="newTitle" placeholder="Nazwa" required>
                        <input type="number" class="form-control" wire:model="newDuration" placeholder="Czas trwania" required>
                        <button class="btn btn-success" type="submit">Dodaj</button>
                    </div>
            </form>


    </div>
</div>
