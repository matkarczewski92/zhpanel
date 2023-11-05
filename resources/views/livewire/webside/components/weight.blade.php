<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Ważenia</span>
         </div>

    <table class="detailsTable">
        <tr class="border-bottom">
            <td>Data ważenia</td>
            <td>Wartość</td>
            <td> </td>
        </tr>
    @foreach ($animal->animalWeights as $weight)
        <tr>
            <td class="align-middle">{{ date('Y-m-d', strtotime($weight->created_at)) }}</td>
            <td class="align-middle">{{ $weight->value}} g.</td>
            <td class="align-middle" style="width:10%">
            </td>
        </tr>
    @endforeach
    </table>
    </div>
</div>


