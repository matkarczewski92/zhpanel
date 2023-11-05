<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Wprowadzanie dostawy</span>
            </div>
            <form wire:submit="addPos">
            <div class="input-group mb-3">
                    <select class="form-select" name="feedId" wire:model="feedId">
                        <option value= "" selected>Wybierz pozycje</option>
                        @foreach ($feed as $f)
                        @if (!in_array($f->id, array_column($receipt, 'feedId')))
                        <option value="{{$f->id}}">{{$f->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <input type="number" class="form-control" name="amount" placeholder="Ilość" wire:model="amount" required>
                    <input type="number" min="0.00"  class="form-control" name="price" placeholder="Wartość" wire:model="price" required>
                </div>
                @if(!empty($status)) <p class="text-center">{{$status}}</p> @endif
                <div class="d-grid gap-2">
                    <button class="btn btn-light" type="submit">Dodaj</button>
                </div>
            </form>
            <div class="strike mb-2 mt-4">
                <span>Rachunek</span>
             </div>
             <table class="detailsTable">
                <tr>
                    <td>Karma</td>
                    <td class="text-center">Ilość</td>
                    <td class="text-center">Wartość</td>
                    <td class="text-center">Wartość</td>
                </tr>
             @foreach ($receipt as $rec)
                @if ($rec['feedId']!='')
                <tr>
                    <td>{{$rec['name']}}</td>
                    <td class="text-center">{{$rec['amount']}}</td>
                    <td class="text-center">{{$rec['price']}}</td>
                    <td class="text-center"><button class="btn" wire:click="remove({{$rec['feedId']}})">D</button></td>
                </tr>
                @endif
             @endforeach
            </table>
            <div class="strike mb-2 mt-4">
                <span>Podsumowanie</span>
            </div>
            <table class="detailsTable">
                <tr>
                    <td style="width:75%"><div class="d-grid gap-2 me-5 ms-5"><button class="btn btn-primary" type="submit"  wire:click="saveReceipt">Dodaj</button></div></td>
                    <td>Łącznie {{$sum}} zł</td>
                </tr>
            </table>
        </div>
    </div>
</div>
