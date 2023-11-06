<div class="card mb-3 bg-dark photobg rounded-1 h-100 " id="printableArea{{$title}}">
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
                    <td style="width:15%">Rodzaj karmy</td>
                    <td>Data karmienia</td>
                    <td class="text-center">Dni do karmienia</td>
                </tr>
                @foreach ($animal as $a)
                <tr class="@if(timeToFeed($a->id)<0) text-danger @elseif (timeToFeed($a->id)==0)text-success @endif">
                    <td><a href="{{ route('animal.profile', $a->id) }}">{!!$a->name!!}</a></td>
                    <td>{{$a->animalFeed->name}}</td>
                    <td>{{nextFeed($a->id)}}</td>
                    <td class="text-center">{{timeToFeed($a->id)}}</td>
                </tr>
                @endforeach
            </table>
            @if (!empty($summary))
            <div class="strike mb-2">
                <span>Podsumowanie</span>
             </div>
             <div class="w-100 text-end">
                <table class="detailsTable ">
                @foreach ($summary as $s =>$v)
                    <tr>
                        <td>{{$s}}</td>
                        <td class="text-center">{{$v}} szt.</td>
                    </tr>
                @endforeach
                </table>

            </div>
            @endif
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
