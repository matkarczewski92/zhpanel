<div>
    @if(!empty($weightHistory[0]))
    <table class="detailsTable">
            <tr class="border-bottom">
                <td>Data ważenia</td>
                <td>Wartość</td>
                <td> </td>
            </tr>
        @foreach ($weightHistory as $weight)
            <tr>
                <td class="align-middle">{{ date('Y-m-d', strtotime($weight->created_at)) }}</td>
                <td class="align-middle">{{ $weight->value}} g.</td>
                <td class="align-middle" style="width:10%">
                    <button class="btn btn-sm" type="submit" wire:click="delete({{$weight->id}})"> <i class="fa-regular fa-trash-can"></i></button></td>
            </tr>
        @endforeach
        </table>
        @endif
        <form wire:submit="addWeight">
            <div class="input-group mb-5 ">
                <span class="input-group-text" id="basic-addon1">Podaj wagę</span>
                <input type="number" class="form-control" wire:model="inputWeight" required>
                <input type="date" class="form-control" wire:model="inputDate" >
                <button type="submit" class="btn btn-success" >Dodaj</button>
            </div>
        </form>


</div>
