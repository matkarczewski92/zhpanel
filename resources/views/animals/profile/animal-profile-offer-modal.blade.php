<div class="modal fade " id="animalOfferModal" tabindex="-1" aria-labelledby="animalOfferModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
      <div class="modal-content ">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="animalOfferModal">Oferta sprzedaży</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="{{ route('offers.store') }}">
            @csrf <!-- {{ csrf_field() }} -->
        <div class="modal-body">
            <div class="strike mb-2 mt-2"><span>Wystaw na sprzedaż</span></div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Cena</span>
                <input type="number" min="0" class="form-control" name="price" value="{{ $animal->animalOffer?->price }}" required>
                <input type="hidden" min="0" class="form-control" name="animalId" value="{{$animal->id}}" required>
                <input type="hidden" min="0" class="form-control" name="offerId" value="{{$animal->animalOffer?->id}}" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Data sprzedaży</span>
                <input type="date" class="form-control" name="sold_date"  value="{{ $animal->animalOffer?->sold_date }}">
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="publicProfile" @if ($animal->public_profile==1) checked @endif>
                <label class="form-check-label" >Włącz profil publiczny</label>
              </div>
            <div class="strike mb-2 mt-2 text-warning"><span>Rezerwacja</span></div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Rezerwujący</span>
                <input type="text" class="form-control" name="booker" value="{{$animal->animalOffer?->offerReservation?->booker}}" >
                <input type="hidden" min="0" class="form-control" name="reservationId" value="{{$animal->animalOffer?->offerReservation?->id}}" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Zadatek</span>
                <input type="number" min="0" class="form-control" name="deposit" value="{{$animal->animalOffer?->offerReservation?->deposit}}" >
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Data ważności</span>
                <input type="date" min="0" class="form-control" value="{{$animal->animalOffer?->offerReservation?->expiration_date}}" name="expiration_date">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1" style="width:30%">Adnotacje</span>
                <textarea class="form-control" name="adnotations">{{$animal->animalOffer?->offerReservation?->adnotations}}</textarea>
            </div>

        </div>
        <div class="modal-footer">
            @if ($animal->animal_category_id!=3)
            <button type="submit" class="btn btn-success">Zapisz</button>
            @else
            <p>Nie można zmienić ani usunąć oferty dla sprzedanego zwierzęcia</p>
            @endif

        </form>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
          @if(!empty($animal->animalOffer->offerReservation->id) AND $animal->animal_category_id!=3)
          <form action="{{ route('offers.destroyreservation',  $animal->animalOffer?->offerReservation?->id) }}" method="post">
            @csrf
            <input type="hidden" min="0" class="form-control" name="resId" value="{{$animal->animalOffer?->offerReservation?->id}}">
          <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">Usuń rezerwacje</button>
          </form>
          @endif
          @if(!empty($animal->animalOffer->id) AND $animal->animal_category_id!=3)

          <a class="btn btn-primary" href="{{ route('sell', $animal->animalOffer->id)}}" role="button">Sprzedaj</a>

          <form action="{{ route('offers.destroy', $animal->animalOffer->id) }}" method="post">
            @method('DELETE')
            @csrf
          <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Usuń ofertę</button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
