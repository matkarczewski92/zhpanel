@extends('layouts.app')

@section('content')

<div class="text-end me-5 mb-4" style="margin-top:-30px">
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProject">Etykiety</button> --}}
</div>
<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Etykiety</span>
         </div>
         <table class="detailsTable  w-100">
            <tr>
                <td>Id</td>
                <td>Nazwa</td>
                <td>Kategoria</td>
                <td>Do wygenerowania</td>
            </tr>
            <form action="{{route('labels-generate')}}" method="POST">
                {{ csrf_field() }}
                @foreach ($animals as $a)
                <tr>
                    <td>{{$a->id}}</td>
                    <td>{!!$a->name!!}</td>
                    <td>{{$a->animalCategory->name}}</td>
                    <td> <input class="form-check-input" type="checkbox" name="animal[{{$a->id}}]"></td>
                </tr>
                @endforeach
                <tr class="text-center">
                    <td colspan="4"><button class="btn btn-primary mt-3 w-25" type="submit">Generuj</button></td>
                </tr>
             <form>
         </table>
    </div>
</div>
@endsection
