<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        @if (session()->has('feed-status'))
        <div class="alert alert-{{ session('feed-status-color') }} alert-dismissible fade show" role="alert">
            {{ session('feed-status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
       @endif
        <div class="strike mb-2">
            <span>Edycja</span>
         </div>
        <form method="post" action="{{route('feeds.update', $feed->id)}}">
            @csrf <!-- {{ csrf_field() }} -->
            @method('patch')
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Nazwa</span>
                <input type="text" class="form-control" name="name" value="{{$feed->name}}" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Interwał karmienia</span>
                <input type="number" class="form-control" name="feeding_interval" value="{{$feed->feeding_interval}}" required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">dni</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Ilość</span>
                <input type="number" class="form-control" name="amount" value="{{$feed->amount}}" required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">szt.</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Cena zakupu zł/sz</span>
                <input type="number" min="0.01" step="0.01" class="form-control" name="last_price" value="{{$feed->last_price}}" required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">zł</span>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                @if ($feed->id != 0)
                <a class="btn btn-danger " onclick=" $('#delete').modal('show');" role="button">Usuń karme</a>
                @endif
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Usuń karmę</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Czy potwierdzasz usunięcie?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wróć</button>
            <form action="{{ route('feeds.destroy', $feed->id) }}" method="post">
                @method('DELETE')
                @csrf
                <input class="btn btn-danger" type="submit" value="Delete" />
             </form>
        </div>
      </div>
    </div>
  </div>
