@extends('layouts.app')

@section('content')
<div class="text-end me-5 mb-4" style="margin-top:-30px"></div>

<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
  <div class="card-body">
    <div class="strike mb-2"><span>Etykiety</span></div>

    {{-- pokaż błędy walidacji, jeśli są --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('labels.generate') }}" method="POST">
      @csrf
      <table class="detailsTable w-100">
        <thead>
        <tr>
          <td>Id</td>
          <td>Nazwa</td>
          <td>Kategoria</td>
          <td>Do wygenerowania</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($animals as $a)
          <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->name }}</td>
            <td>{{ $a->animalCategory->name }}</td>
            <td>
              {{-- KLUCZOWA ZMIANA: name="animal[]" + value="{{ $a->id }}" --}}
              <input class="form-check-input" type="checkbox" name="animal[]" value="{{ $a->id }}">
            </td>
          </tr>
        @endforeach

        <tr class="text-center">
          <td colspan="4">
            <button class="btn btn-secondary mt-3 me-2 w-25" type="submit" name="action" value="preview">
              Generuj do druku
            </button>
            <button class="btn btn-primary mt-3 w-25" type="submit" name="action" value="export">
              Generuj do pliku
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
@endsection
