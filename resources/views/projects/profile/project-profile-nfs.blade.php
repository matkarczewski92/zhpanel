<div class="strike mb-2">
    <span class="h4">Do zatrzymania - NFS</span>
</div>
<table class="tdetailsTable text-light w-100">
    <tr>
        <td style="width:5%">%</td>
        <td>Nazwa</td>
        <td>Płeć</td>

    </tr>
@foreach ($stage->getStagesNfs ?? [] as $pO)
    <tr>
        <td>{{$pO->percent}} %</td>
        <td>{{$pO->title}}</td>
        <td>
            @if ($pO->sex == 2) Samiec @endif
            @if ($pO->sex == 3) Samica @endif
        </td>
    </tr>
@endforeach
</table>
