
<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
        <i class="fa-solid fa-pen"></i>
    </button>
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span >Planowane potomstwo </span>
        </div>
        @if ($litterRepo->litterOffspringPercentCount($litterId)<100)
            <div class="alert alert-warning " role="alert">
                Nieprawidłowa suma procentowa
            </div>
        @endif
        <table class="detailsTable">
            <tr class="border-bottom">
                <td style="width:8%">Procent</td>
                <td colspan="2" style="width:65%">Nazwa</td>
                <td style="width:5%">NFS</td>
                <td style="width:10%" class="text-center">Wartość</td>
                <td style="width:10%"></td>
            </tr>
            @foreach ($offspring as $og)
            <tr>
                <td>{{ $og->percent }}%</td>
                <td>{{ $og->title_vis }}</td>
                <td>{{ $og->title_het }}</td>
                <td>@if($litterRepo->checkNfs($og->id)!=0) <a href="{{ route('not-for-sale.index') }}">TAK</a> @endif</td>
                <td class="text-center"> </td>
                <td class="text-end">
                    <a wire:click="edit({{$og->id}})"><i class="fa-solid fa-pen-to-square fa-lg me-2"></i></a>
                    <a wire:click="delete({{$og->id}})"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            @if ($offspringEditMode == $og->id)
            <tr>
                <td colspan="5">
                    <div class="row mb-1 mt-1">
                        <div class="col-2"><div class="input-group mb-3"><input type="number" class="form-control"  wire:model="ofspringEditPercent" r><span class="input-group-text" id="basic-addon1">%</span></div></div>
                        <div class="col"> <input type="text" class="form-control" placeholder="Wprować geny wizualne" wire:model="ofspringEditVis"></div>
                        <div class="col"><input type="text" class="form-control" placeholder="Wprowadź hety" wire:model="ofspringEditHet"> </div>
                        <div class="col-1"><button type="submit" class="btn btn-success" wire:click="update">Dodaj</button></div>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
        </table>
        @if($editMode == 1)
        @error('percent') <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@enderror
        @error('titleVis') <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@enderror
        <div class="strike mb-2  mt-4">
        <span>Dodaj możliwe potomstwo</span>
        </div>
        <div class="row me-1 ms-1 ">
            <div class="col-2"><div class="input-group mb-3"><input type="number" class="form-control"  wire:model="percent"><span class="input-group-text" id="basic-addon1">%</span></div></div>
            <div class="col"> <input type="text" class="form-control" placeholder="Wprować geny wizualne" wire:model="titleVis"></div>
            <div class="col"><input type="text" class="form-control" placeholder="Wprowadź hety" wire:model="titleHet"> </div>
            <div class="col-1"><button type="submit" class="btn btn-success" wire:click="create">Dodaj</button></div>
        </div>
        @endif

    </div>
</div>

