@extends('layouts.app')

@section('content')
<div class="row container-fluid">
    <div class="col col-1 d-none d-lg-block d-xl-block" style="width: 5.0rem; ">
        <div class="d-flex flex-column flex-shrink-0 text-bg-dark mb-1 rounded sidemenu ">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center ">
                <li>
                    <a href="{{ route('projects.show', $project->id) }}" class="nav-link py-3 rounded-0" aria-current="page" title="Wróć" data-bs-toggle="tooltip" data-bs-placement="right">
                        <i class="fa-solid fa-circle-arrow-left fa-xl" style="color: #297f3f;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col">
        <div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1">
            <div class="card-body " style="">
                <div class="strike mb-2">
                    <span class="h4">Edycja Etap: {{$stage->season}} - Projekt: {{ $project->title }} </span>
                </div>
                    @include('projects.profile.projects-profile-parents', ['stage' => $stage])
            </div>
        </div>

        @include('projects.profile.projects-profile-stages-edit-possible')

        @include('projects.profile.projects-profile-stages-nfs')

        @include('projects.profile.projects-profile-stages-edit-nfs-create')
    </div>
</div>
<div class="row container-fluid">
    @if (!is_null($litter))
        @if ((is_null($litter->where('category', 1)->where('season', $stage->season)->first()) AND is_null($litter->where('category', 2)->where('season', $stage->season)->first())) AND (!is_null($stage->getParentMaleDetails->first()) AND !is_null($stage->getParentFemaleDetails->first())))
        <div class="col">
            <a type="button" href="{{ route('project.stages.create-litter', [$project, $stage]) }}" class="btn btn-warning w-100">Dodaj planowany miot</a>
        </div>
        @endif
    @endif
</div>
<div class="row container-fluid mt-3 mb-5">
    <div class="col">
        <form action="{{route('projects.stages.destroy', ['project' => $project, 'stage'=>$stage])}}" method="post">@csrf @method('DELETE')
            <button type="submit" class="btn btn-danger  w-100">Usuń etap</button>
        </form>
    </div>
</div>

@endsection
