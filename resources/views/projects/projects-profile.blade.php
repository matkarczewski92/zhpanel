@extends('layouts.app')

@section('content')
<div class="text-end me-5 mb-4" style="margin-top:-30px">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStage">Dodaj nowy etap</button>
</div>
    @foreach ($stages as $stage)
        <div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1">
            <a type="button" href=" {{ route('projects.stages.edit', [$project, $stage]) }} " class="btn btn-success rounded-circle editmode">
                <i class="fa-solid fa-pen"></i>
            </a>
            <form action="{{route('projects.stages.destroy', [$project, $stage])}}" method="post">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger rounded-circle editmodeB">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </form>
            <div class="card-body " style="">
                <div class="strike mb-2">
                    <span class="h4">{{$stage->season}}</span>
                </div>
                @include('projects.profile.projects-profile-parents', ['stage' => $stage])

                @if (!empty($stage->getStagesNfs->first()))
                    @include('projects.profile.project-profile-nfs')
                @endif
            </div>
        </div>
    @endforeach

@include('projects.modals.projects-create-stage')
@endsection
