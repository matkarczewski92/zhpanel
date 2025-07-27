@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5">
    <div class="col " style="margin-top: -20px">
        <div class="row text-center">
        @php
            $selectedYear = request()->input('year');
            $defaultYear = date('Y');
        @endphp

        <div class="btn-group" role="group" aria-label="Wybór roku">
            @foreach ($yearArray as $year)
                @php
                    $isSelected = ($selectedYear && $selectedYear == $year) || (!$selectedYear && $year == $defaultYear);
                    $btnClass = $isSelected ? 'btn-primary' : 'btn-success';
                @endphp

                <a href="{{ url()->current() }}?year={{ $year }}" class="btn {{ $btnClass }} me-2 mb-2">
                    {{ $year }}
                </a>
            @endforeach
        </div>

        </div>
        <div class="row">
            <div class="card mb-3 bg-dark photobg rounded-1 h-100">
                <div class="card-body " style="">
                    <div class="strike mb-2">
                        <span>Możliwe potomstwo</span>
                     </div>
                     <table class="tdetailsTable text-light w-100" id="animalTable" data-page-length='50'>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Kod miotu</td>
                                <td>Sezon</td>
                                <td>Nazwa</td>
                                <td>Hom</td>
                                <td>Het</td>
                                <td>Percent</td>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($litters as $key => $litter)
                                @foreach ($litter as $lt)
                                @php
                                $litterData = $litterRepo->getById($key);
                                $main_genes = $lt['main_genes'];
                                $additional_genes = $lt['additional_genes']; 
                                $dominant = $lt['dominant']; 
                                
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
                                    <td>{{$litterData->id}}</td> 
                                    <td><a href="{{ route('litters.show', $litterData->id)}}">{{$litterData->litter_code}}</a></td> 
                                    <td>{{$litterData->season}}</td> 
                                    <td>@if($lt['traits_name'])@foreach($newDom as $dom) {!!$dom!!} @endforeach @endif <span class="badge text-bg-light">{{$lt['traits_name']}}</span></td>
                                    <td>@foreach($newDom as $dom) {!!$dom!!} @endforeach @foreach($newMains as $mains) {!!$mains!!} @endforeach</td>
                                    <td>@foreach($newHets as $hets) {!!$hets!!} @endforeach</td>
                                    <td>{{number_format($lt['percentage'], 2)}}%</td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
    $('#animalTable').DataTable();
} );
</script>
@endsection


