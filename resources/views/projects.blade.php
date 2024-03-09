@extends('layouts.app')

@section('content')


<div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Projekty</span>
         </div>
         <table class="tdetailsTable text-light w-100">
            <tr>
                <td style="width: 5%">ID</td>
                <td>Nazwa</td>
            </tr>
            @foreach ($projects as $project)
            <tr>
                <td><a href="{{ route('projects.show', $project->id) }}">{{$project->id}}</a></td>
                <td><a href="{{ route('projects.show', $project->id) }}">{{$project->title}}</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection
