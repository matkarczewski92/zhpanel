<div>
    <div class="modal-content">
    {{-- etap pierwszy      --}}
        <div class="input-group">
            <span class="input-group-text">Samica:</span>
            <select id="femaleSelect"
                    class="form-select"
                    wire:model.live="selectedFemale">
                <option value="">-- wybierz --</option>
                @foreach($females as $female)
                    <option value="{{ $female->id }}">{!! $female->name !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
{{-- przykładowe użycie wybranej wartości --}}
@if($selectedFemale)
    <div class="mt-2">
        @foreach ($finale as $name => $fnMale)
        <h3>{!! $name !!}</h3>
        <table class="detailsTable">
            <tr class="border-bottom">
                <td style="width:8%">Procent</td>
                <td style="width:10%">Nazwa</td>
                <td style="width:25%">Homozygota</td>
                <td style="width:57%">Heterozygota</td>
            </tr>
            @foreach ($fnMale as $row)
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
            <hr class="mb-5">
         @endforeach
    </div>
@endif
</div>






 