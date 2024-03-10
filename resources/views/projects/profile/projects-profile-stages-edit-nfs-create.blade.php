<div class="card mb-5 me-4 ms-4 bg-dark photobg rounded-1">

    <div class="card-body " style="">
        <div class="strike mb-2">
            <span class="h4">NSF - dodaj</span>
        </div>
        <form action="{{route('projects.stages.nfs.store', ['project' => $project , 'stage' => $stage])}}" method="post">
            @csrf
        @if (!is_null($litter))
        @php
        $litterData = ($litter->where(function($lD){$lD->where('category', 1)->orWhere('category', 2);})->where('season', $stage->season)->first())
            ?  $litter->where(function($lD){$lD->where('category', 1)->orWhere('category', 2);})->where('season', $stage->season)->first()->getPossibleOffspring
            :  $litter->where('category', 3)->where('season', null)->first()->getPossibleOffspring
        @endphp
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="possibleOff">
                <option value="" selected>Wybierz z dostępnych łączeń</option>
                @foreach ($litterData ?? [] as $pO)
                <option value="{{$pO->id}}">{{$pO->percent}}% : {{$pO->title_vis}} - {{$pO->title_het}}</option>
                @endforeach
            </select>
        </div>
        <div class="strike mb-2">
            <span class="h4">Lub</span>
        </div>
        @endif

        <div class="input-group mb-3">
            <span class="input-group-text">%</span>
            <input type="text" class="form-control" name="percent">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Nazwa</span>
            <input type="text" class="form-control" name="title">
        </div>

        <div class="input-group mb-3">
            <select class="form-select" name="sex" required>
                <option value="" selected>Wybierz płeć</option>
                <option value="2">Samiec</option>
                <option value="3">Samica</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Dodaj</button>

    </form>
    </div>
</div>
