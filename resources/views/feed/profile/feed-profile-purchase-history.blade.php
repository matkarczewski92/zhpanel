<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Historia zakupów</span>
         </div>
        <table class="detailsTable">
            <tr class="border-bottom">
                <td>Tytuł</td>
                <td>Kwota</td>
                <td style="width:20%">Data</td>
            </tr>
            @foreach ($costs as $fC)
            <tr>
                <td>{{ $fC->title}} </td>
                <td>{{ $fC->amount}} zł</td>
                <td>{{ $fC->created_at->format("Y-m-d")}} </td>
            </tr>
            @endforeach
        </table>
        {{ $costs->links() }}
    </div>
</div>
