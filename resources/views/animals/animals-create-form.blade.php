@extends('layouts.app')

@section('content')

<div class="container bg-dark photobg rounded" id="dodaj" tabindex="-1" aria-labelledby="dodajWeza" aria-hidden="show" >

    <div class="modal-dialog modal-dialog-centered modal-xl ">
      <div class="modal-content ">
        <div class="modal-header">
          <h1 class="modal-title fs-5 mt-3" id="exampleModalLabel">Dodaj węża</h1>
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
            <form method="post" action="{{ route('animals.store') }}">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="strike mb-3 mt-2">
                    <span>Dane podstawowe</span>
                 </div>
                <div class="input-group mb-3 mt-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Typ</span>
                    <select class="form-select form-select" name="animal_type_id" required >
                        @foreach ($types as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Status</span>
                    <select class="form-select form-select" name="animal_category_id" required>
                        @foreach ($category as $c)
                        @if ($c->id != 0)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endif
                        @endforeach
                      </select>
                </div>
                <div class="strike mb-3">
                    <span>Dane szczegółowe</span>
                 </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Nazwa</span>
                    <input type="text" class="form-control" name="name" aria-describedby="basic-addon1" value="{{old('name')}}" required>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Płeć</span>
                    <select class="form-select form-select" name="sex" aria-label="Large select example">
                        <option value="1" selected>N/sex</option>
                        <option value="2" >Samiec</option>
                        <option value="3">Samica</option>
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Data wyklucia</span>
                    <input type="date" class="form-control {{$errors->first('date_of_birth') ? 'border-danger' : null}}" value="{{old('date_of_birth')}}" placeholder="Data wyklucia" aria-label="Data wyklucia" name="date_of_birth" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Miot</span>
                    <select class="form-select form-select" name="litter_id" aria-label="Large select example">
                        <option value="">Wykluty poza hodowlą</option>
                        @foreach ($litters as $lit)
                        <option value="{{ $lit->id }}">{{ $lit->litter_code }}</option>
                        @endforeach
                      </select>
                      <span class="input-group-text" id="basic-addon1" style="min-width:10%">Opcjonalne</span>
                </div>
                <div class="strike mb-3">
                    <span>Karmienie</span>
                 </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Podstawowa karma</span>
                    <select class="form-select form-select" name="feed_id" required>
                        @foreach ($feedTypes as $fT)
                        @if ($fT->id != 0)
                        <option value="{{ $fT->id }}">{{ $fT->name }}</option>
                        @endif
                        @endforeach
                      </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1" style="width:25%">Opc. interwał karmienia</span>
                    <input type="number" min="0" class="form-control  placeholder="" aria-label="" name="feed_interwal" aria-describedby="basic-addon1" nullable>
                </div>
        </div>
        <div class="modal-footer mb-5">
            <button type="reset" class="btn btn-secondary me-3">Wyczyść</button>
            <a class="btn btn-primary me-3" href="{{ url('animal') }}" role="button">Wróć</a>
            <button type="submit" class="btn btn-success">Dodaj</button>
            </form>
        </div>
      </div>
    </div>
  </div>
  @endsection

