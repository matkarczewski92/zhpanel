@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 ">
    <div class="col col-1 d-none d-lg-block d-xl-block" style="width: 5.5rem; ">
{{-- SIDE MENU START --}}
<div class="d-flex flex-column flex-shrink-0 text-bg-dark mb-1 rounded sidemenu ">
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center ">
        <li>
            <a href="{{ url()->previous(); }}" class="nav-link py-3 rounded-0" aria-current="page" title="Wróć" data-bs-toggle="tooltip" data-bs-placement="right">
                <i class="fa-solid fa-circle-arrow-left fa-xl" style="color: #297f3f;"></i>
            </a>
        </li>
    </ul>
</div>
    </div>
{{-- SIDE MENU END --}}
    <div class="col " style="margin-top: -20px">
        <div class="row">
<div class="container  rounded " id="dodaj" tabindex="-1" aria-labelledby="dodajWeza" aria-hidden="show" >

    <div class="modal-dialog modal-dialog-centered modal-xl bg-dark rounded photobg">
      <div class="modal-content m-3 ">
        <div class="modal-header">
          <h1 class="modal-title fs-5 mt-3" id="exampleModalLabel">Edycja węża: {!! $profil->name!!}</h1>
        </div>
        <div class="modal-body ">
            @if ($errors->any())
            <div class="alert alert-danger mt-5">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form method="post" action="{{ route('animals.update', $profil->id) }}">
                @method('patch')
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="animalId" value="{{$profil->id}}">
                <div class="strike mb-3 mt-2">
                    <span>Dane podstawowe</span>
                 </div>
                <div class="input-group mb-3 mt-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Typ</span>
                    <select class="form-select form-select" name="animal_type_id" aria-label="Large select example" >
                        @foreach ($types as $t)
                        <option value="{{ $t->id }}" @if($profil->animal_type_id == $t->id) selected @endif>{{ $t->name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Status</span>
                    <select class="form-select form-select" name="animal_category_id" aria-label="Large select example">
                        @foreach ($category as $c)
                        <option value="{{ $c->id }}" @if($profil->animal_category_id == $c->id) selected @endif>{{ $c->name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="strike mb-3">
                    <span>Dane szczegółowe</span>
                 </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Nazwa</span>
                    <input type="text" class="form-control {{$errors->first('name') ? 'border-danger' : null}}" name="name" aria-describedby="basic-addon1" value="{{ $profil->name }}">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Płeć</span>
                    <select class="form-select form-select" name="sex" aria-label="Large select example">
                        <option value="1" @if($profil->sex == 1) selected @endif>N/sex</option>
                        <option value="2" @if($profil->sex == 2) selected @endif>Samiec</option>
                        <option value="3" @if($profil->sex == 3) selected @endif>Samica</option>
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Data wyklucia</span>
                    <input type="date" class="form-control {{$errors->first('date_of_birth') ? 'border-danger' : null}}" value="{{ $profil->date_of_birth}}" placeholder="Data wyklucia" aria-label="Data wyklucia" name="date_of_birth" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Miot</span>
                    <select class="form-select form-select" name="litter_id" aria-label="Large select example">
                        <option value="">Wykluty poza hodowlą</option>
                        @foreach ($litters as $lit)
                        <option value="{{ $lit->id }}" @if($profil->litter_id == $lit->id) selected @endif>{{ $lit->litter_code }}</option>
                        @endforeach
                      </select>
                      <span class="input-group-text" id="basic-addon1" style="min-width:10%">Opcjonalne</span>
                </div>
                <div class="strike mb-3">
                    <span>Karmienie</span>
                 </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Podstawowa karma</span>
                    <select class="form-select form-select" name="feed_id" aria-label="Large select example">
                        @foreach ($feedTypes as $fT)
                        <option value="{{ $fT->id }}" @if($profil->feed_id == $fT->id) selected @endif>{{ $fT->name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Opc. interwał karmienia</span>
                    <input type="number" min="0" value="{{$profil->feed_interval}}" class="form-control {{$errors->first('feed_interwal') ? 'border-red-500' : null}}" placeholder="" aria-label="" name="feed_interval" aria-describedby="basic-addon1" nullable>
                </div>
        </div>
        <div class="modal-footer mb-5">
            <a class="btn btn-primary me-3" href="{{ URL::previous() }}" role="button">Wróć</a>
            <a class="btn btn-danger me-3" onclick=" $('#delete').modal('show');" role="button">Usuń węża</a>
            <button type="submit" class="btn btn-success">Edytuj</button>
            </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Usuń węża</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Czy potwierdzasz usunięcie?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wróć</button>
            <form action="{{ route('animals.destroy', $profil->id) }}" method="post">
                @method('DELETE')
                @csrf
                <input class="btn btn-danger" type="submit" value="Delete" />
             </form>
        </div>
      </div>
    </div>
  </div>
  @endsection

