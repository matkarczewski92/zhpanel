<div class="card mb-3 bg-dark photobg rounded-1 " id="printableArea{{$title}}">
    <div class="card-body " style="">
        <button type="button" onclick="printDiv('printableArea{{$title}}')" class="btn btn-success rounded-circle editmode">
            <i class="fa-solid fa-print"></i>
        </button>
        <div class="strike mb-2">
            <span>{{$title}}</span>
         </div>
        <div>
            <table class="detailsTable">
                <tr class="border-bottom">
                    <td>Nazwa zwierzęcia</td>
                    <td>Ostatnia waga</td>
                    <td>Ost. ważenia</td>
                    <td class="text-center">Dni do ważenia</td>
                </tr>
                @foreach ($animal as $a)
                <tr class="@if($animalRepo->timeToFeed($a->id)<0) text-danger @elseif ($animalRepo->timeToFeed($a->id)==0)text-success @endif">
                    <td>{{$a->id}}. <a href="{{ route('animal.profile', $a->id) }}">{!!$a->name!!}</a></td>
                    <td>{{$animalRepo->lastWeight($a->id)}} g.</td>
                    <td>{{$animalRepo->lastWeighting($a->id)}}</td>
                    <td class="text-center">{{$animalRepo->timeToWeight($a->id)}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.style.color = "black";
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</div>
