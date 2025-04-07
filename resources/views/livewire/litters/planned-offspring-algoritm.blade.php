
<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span >Planowane potomstwo - algorytm</span>
        </div>
        <table class="detailsTable">
            <tr class="border-bottom">
                <td style="width:8%">Procent</td>
                <td style="width:10%">Nazwa</td>
                <td style="width:30%">Homozygota</td>
                <td style="width:52%">Heterozygota</td>
            </tr>
            
        @foreach ($finale as $row)
            @php
                $main_genes = $row['main_genes'];
                $traits = $row['traits_name'];
                $additional_genes = $row['additional_genes']; 
                $dominant = $row['dominant']; 
                
                $hets = explode(", ", $additional_genes);
                rsort($hets);
                $newHets = [];
                foreach ($hets as $h) {
                    if(strpos($h, "50%")!== false){
                        $newHets[] = '<span class="badge text-bg-secondary">'.$h.'</span>';
                        
                    } else if(strpos($h, "66%")!== false){
                        $newHets[] = '<span class="badge text-bg-info">'.$h.'</span>';
                        
                    } else if(strpos($h, "1/2")!== false){
                        $newHets[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                        
                    } else $newHets[] = '<span class="badge text-bg-primary">'.$h.'</span>';
                }

                $mains = explode(", ", $main_genes);
                sort($mains);
                $newMains = [];
                foreach ($mains as $h) {
                    $newMains[] = '<span class="badge text-bg-success">'.$h.'</span>';
                }
                $dom = explode(", ", $dominant ?? '');
                sort($mains);
                $newDom = [];
                foreach ($dom as $h) {
                    $newDom[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                }
                
            @endphp
        <tr>
            <td>{{number_format($row['percentage'], 2)}}%</td>
            <td><span class="badge text-bg-light">{{$traits}}</span></td>
            <td>@foreach($newDom as $dom) {!!$dom!!} @endforeach @foreach($newMains as $mains) {!!$mains!!} @endforeach</td>
            <td>@foreach($newHets as $hets) {!!$hets!!} @endforeach</td>
        </tr>
        @endforeach
        </table>

    </div>
</div>

