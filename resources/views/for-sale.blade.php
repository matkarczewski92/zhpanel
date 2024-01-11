@extends('layouts.app')

@section('content')
<div class="text-end me-5 mb-4" style="margin-top:-30px">
    <a type="button" class="btn btn-success" href="{{ route('animals.create') }}">Dodaj</a>
</div>
@if (session('animals-status'))
<div class="alert alert-{{ session('animals-status-color') }} alert-dismissible fade show" role="alert">
    {!! session('animals-status') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>{{ $title }}</span>
             </div>
                    <div style="float: right;" class="hidden-result me-3 mb-4">
                        <button class="btn btn-outline-primary jsBtnWaga active">Waga</button>
                        <button class="btn btn-outline-primary jsBtnKarma active">Karma</button>
                        <button class="btn btn-outline-primary jsBtnOstatnie active">Data o.karmienia</button>
                        <button class="btn btn-outline-primary jsBtnNastepne active">Data n.karmienia</button>
                        <button class="btn btn-outline-primary jsBtnInterwal active">Interwał</button>
                    </div>
                    <table class="detailsTable  w-100" id="animalTable" data-page-length='50'>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td style="width: 30%">Nazwa</td>
                                <td>Oferta</td>
                                <td>Płeć</td>
                                <td class="optWaga">Waga</td>
                                <td class="optKarma hidden-result">Karma</td>
                                <td class="optOstatnie hidden-result">Data o. karmienia</td>
                                <td class="optNastepne hidden-result">Data n. karmienia</td>
                                <td class="optInterwal hidden-result">Interwał karmienia</td>
                                <td>Data sprzedaży</td>
                                <td> </td>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($animal ?? [] as $an)
                            @php
                                $sex = $animalRepo->sexName($an->sex);
                                $lastWeight = $animalRepo->lastWeight($an->id);
                                $feedInterval = $animalRepo->feedInterval($an->id);
                                $lastFeed = $animalRepo->lastFeed($an->id);
                                $nextFeed = $animalRepo->nextFeed($an->id);
                                $offer = ($an->animalOffer?->id) ? 'TAK' : 'NIE';
                            @endphp
                            <tr >
                                <td>{{$an->id}}</td>
                                <td><a href="{{ route('animal.profile', $an->id)}}">{!!$an->name!!}</a></td>
                                <td>{{ $offer }}</td>
                                <td>{{ $sex }}</td>
                                <td class="optWaga">{{ $lastWeight }} </td>
                                <td class="optKarma hidden-result">{{ $an->animalFeed?->name }}</td>
                                <td class="optOstatnie hidden-result">{{ $lastFeed}} </td>
                                <td class="optNastepne hidden-result">{{ $nextFeed}} </td>
                                <td class="optInterwal hidden-result">{{ $feedInterval}} </td>
                                <td>{{ $an->animalOffer?->soldDate}} </td>
                                <td><a href="{{ route('animal.profile', $an->id)}}"><i class="fa-solid fa-circle-info fa-lg"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

</div>

<script>
    $(document).ready( function () {
    $('#animalTable').DataTable();
} );
</script>
@endsection


