<div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        {{$project->annotations->id}}
        @if (is_null($project->annotations))
            <form action="{{ route('project.annotations.store', ['project' => $project]) }}" method="post">
                @csrf
        @else
            <form action="{{ route('project.annotations.update', ['project' => $project, 'annotation' => $project->annotations]) }}" method="post">
                @csrf @method('PUT')
        @endif

        <button type="submit" class="btn btn-success rounded-circle editmode">
            <i class="fa-regular fa-floppy-disk fa-lg"></i>
        </button>
        <div class="strike mb-2">
            <span>Adnotacje</span>
         </div>
         <textarea class="adnotations h-100" name="annotations" rows="6">{{ $project->annotations->annotations }}</textarea>
        </form>
         @if (Session::get('status') ?? '' == 'ok')
         <p class="text-center text-success">Zapisano pomyślnie</p>
        @endif
    </div>
</div>
