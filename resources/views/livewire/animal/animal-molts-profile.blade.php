<div>
    <div class="card mb-3 mt-4 bg-dark photobg rounded-1">
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Wylinki</span>
             </div>
             @if (session()->has('animalMolt'))
             <div class="alert alert-{{ session('animalMoltColor') }} alert-dismissible fade show" role="alert">
                 {{ session('animalMolt') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            @endif
             <table class="detailsTable">
                <tr>
                    <td >Data</td>
                    <td style="width:10%"></td>
                </tr>
                @foreach ($molts as $mt)
                <tr>
                    <td style="width:75%">{{$mt->created_at->format("Y-m-d")}}</td>
                    <td><button class="btn btn-sm" type="submit" wire:click="delete({{$mt->id}})"> <i class="fa-regular fa-trash-can"></i></button></td></td>
                </tr>
                @endforeach
             </table>
             <div style="margin-top: 40px">
                <div class="position-absolute bottom-0 end-0 me-3">
                    {{ $molts->links() }}
                </div>
            </div>

             {{-- <hr/> --}}
             @if ($editMode == 1)
             <hr/>
             <form wire:submit="addMolt">
                <div class="input-group mb-5">
                    <span class="input-group-text" id="basic-addon1">Data wylinki:</span>
                    <input type="date" class="form-control" wire:model="date">
                    <button type="submit" class="btn btn-success" >Dodaj</button>
                    </form>
                </div>
                @endif
        </div>
    </div>

</div>
