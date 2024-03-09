<div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="addProject" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addProject">Dodaj projekt</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{route('projects.store')}}" method="post">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Nazwa projektu</span>
                            <input type="text" class="form-control" name="title">
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





