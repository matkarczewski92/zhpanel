<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Wylinki</span>
         </div>
         <table class="detailsTable">
            <tr>
                <td >Data</td>
            </tr>
            @foreach ($animal->animalMolts as $mt)
            <tr>
                <td style="width:75%">{{$mt->created_at->format("Y-m-d")}}</td>
            </tr>
            @endforeach
         </table>
    </div>
</div>
