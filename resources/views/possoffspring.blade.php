@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5">
    <div class="col " style="margin-top: -20px">
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
                                @endphp
                                <tr>
                                    <td>{{$litterData->id}}</td> 
                                    <td>{{$litterData->litter_code}}</td> 
                                    <td>{{$litterData->season}}</td> 
                                    <td>{{$lt['main_genes']}}</td>
                                    <td>{{$lt['additional_genes']}}</td>
                                    <td>{{$lt['percentage']}}%</td>
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


