<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Dodawanie nowej karmy</span>
         </div>
         <form method="post" action="{{route('feeds.store')}}">
            @csrf <!-- {{ csrf_field() }} -->
            {{-- @method('patch') --}}
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Nazwa</span>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Interwał karmienia</span>
                <input type="number" class="form-control" name="feeding_interval" required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">dni</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Ilość</span>
                <input type="number" class="form-control" name="amount" required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">szt.</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Cena zakupu zł/sz</span>
                <input type="number" min="0.00" step="0.01" class="form-control" name="last_price"  required>
                <span class="input-group-text" id="basic-addon1" style="width:10%">zł</span>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Dodaj</button>
            </div>
        </form>
    </div>
</div>
