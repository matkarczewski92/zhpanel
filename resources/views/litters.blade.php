@extends('layouts.app')

@section('content')

@if (session('litters-status'))
<div class="alert alert-{{ session('litters-status-color') }} alert-dismissible fade show mb-5 me-5 ms-5" role="alert" style="margin-top:-30px">
    {!! session('litters-status') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="text-end me-5" style="margin-top:-30px">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLitter">Dodaj nowy miot</button>
</div>
<div class="card mb-3 me-4 ms-4 mt-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Aktualne mioty</span>
         </div>
         @include('litters.litters-list', ['data' => $littersActual])
    </div>
</div>

<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike strike-with-action mb-2">
            <span>Planowane mioty</span>
            @if($plannedSeasons->isNotEmpty())
                <button type="button"
                        class="btn btn-danger rounded-circle strike-action-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#bulkDeletePlannedModal"
                        title="Masowe usuwanie">
                    <i class="fa-solid fa-trash"></i>
                </button>
            @endif
         </div>
         @include('litters.litters-list', ['data' => $littersPlan])
    </div>
</div>

<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Zakończone mioty</span>
         </div>
         @include('litters.litters-list', ['data' => $littersClose])
    </div>
</div>

{{-- @include('litters.components.litters-create-from-template-modal') --}}
@include('litters.components.litters-create-modal')

@if($plannedSeasons->isNotEmpty())
<div class="modal fade" id="bulkDeletePlannedModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Usun planowane mioty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('litters.bulk-destroy-planned') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulkDeleteSeason" class="form-label">Sezon</label>
                        <select id="bulkDeleteSeason" name="season" class="form-select" required>
                            <option value="">-- wybierz --</option>
                            @foreach($plannedSeasons as $season)
                                <option value="{{ $season }}">{{ $season }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-muted small mb-0">
                        Usuwane beda tylko mioty bez daty laczenia i z terminem w przyszlosci. Mioty z ustawiona data laczenia zostana pominiete.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-danger">Usun sezon</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
