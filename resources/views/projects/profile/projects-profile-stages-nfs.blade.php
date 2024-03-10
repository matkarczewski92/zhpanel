<div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span class="h4">Do zostawienia w hodowli - NFS</span>
        </div>
        <table class="tdetailsTable text-light w-100">
            <tr>
                <td style="width:5%">%</td>
                <td>Nazwa</td>
                <td>Płeć</td>
                <td style="width:5%"></td>

            </tr>
        @foreach ($stage->getStagesNfs ?? [] as $pO)
            <tr>
                <td>{{$pO->percent}} %</td>
                <td>{{$pO->title}}</td>
                <td>
                    @if ($pO->sex == 2) Samiec @endif
                    @if ($pO->sex == 3) Samica @endif
                </td>
                <td>
                    <form action="{{route('projects.stages.nfs.destroy', [$project, $stage, $pO])}}" method="post">@csrf @method('DELETE')
                        <button type="submit" class="btn"><i class="bi bi-trash-fill text-danger"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </table>
    </div>
</div>
