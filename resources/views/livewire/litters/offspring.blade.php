<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <button type="button" data-bs-toggle="modal" data-bs-target="#addAnimals" class="btn btn-success rounded-circle editmode">
                <i class="fa-solid fa-pen"></i>
            </button>
            <div class="strike mb-2">
                <span>Potomstwo</span>
             </div>
             <table class="detailsTable">
                <tr class="border-bottom">
                    <td style="width:45%">Nazwa</td>
                    <td class="text-center">Płeć</td>
                    <td class="text-center">Waga</td>
                    <td class="text-center">Liczba karmień</td>
                    <td class="text-center">Data wyklucia</td>
                    <td class="text-center">Status</td>
                </tr>
                    @foreach ($animals as $animal)
                    <tr>
                        <td><a href="{{ route('animal.profile', $animal->id)}} ">{!! $animal->name !!}</td>
                        <td class="text-center">{{ $animalRepo->sexName($animal->sex) }}</td>
                        <td class="text-center">{{ $animalRepo->lastWeight($animal->id) }}</td>
                        <td class="text-center">{{ $animalRepo->feedCount($animal->id) }}</td>
                        <td class="text-center">{{ $animal->date_of_birth }}</td>
                        <td class="text-center">{{ $animalRepo->animalStatus($animal->id) }}</td>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>

    <div class="modal fade" id="addAnimals" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addAnimals">Dodaj zwierzęta do miotu</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="addAnimals()">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Podaj ilość</span>
                    <input type="number" min="1" class="form-control" value="1" wire:model="createAmount">
                    <button type="submit" class="btn btn-success">Dodaj</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>

</div>
