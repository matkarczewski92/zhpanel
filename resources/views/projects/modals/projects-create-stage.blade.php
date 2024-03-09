<div class="modal fade" id="addStage" tabindex="-1" aria-labelledby="addStage" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addStage">Dodaj etap</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{route('projects.stages.store', ['project' => $project])}}" method="post">
                @csrf <!-- {{ csrf_field() }} -->

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Sezon</span>
                    <input type="number" min="2023" max="2099" step="1" class="form-control" name="season" required>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Samiec</span>
                            <select class="form-select" name="parent_male_id">
                                <option value="" selected>Wybierz lub wprowadź poniżej</option>
                                @foreach ($animalsMales as $aM)
                                <option value="{{$aM->id}}">{!! $aM->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Samiec poza hodowlą</span>
                            <input type="text" class="form-control" name="parent_male_name">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Samica</span>
                            <select class="form-select" name="parent_female_id">
                                <option value="" selected>Wybierz lub wprowadź poniżej</option>
                                @foreach ($animalsFemales as $aF)
                                <option value="{{$aF->id}}">{!! $aF->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Samica poza hodowlą</span>
                            <input type="text" class="form-control" name="parent_female_name">
                        </div>
                    </div>
                </div>





            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </div>
            </form>
        </div>
    </div>
</div>





