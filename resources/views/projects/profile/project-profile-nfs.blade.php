<div class="strike mb-2">
    <span class="h4">Do zatrzymania - NFS</span>
</div>
<table class="tdetailsTable text-light w-100">
    <tr>
        <td style="width:5%">%</td>
        <td>Nazwa</td>

    </tr>
@foreach ($stage->getStagesNfs ?? [] as $pO)
    <tr>
        <td>{{$pO->percent}} %</td>
        <td>{{$pO->title}}</td>
    </tr>
@endforeach
</table>
