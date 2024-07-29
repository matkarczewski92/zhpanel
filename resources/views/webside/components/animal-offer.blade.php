<div class="col">
    <div class="card h-100">
        <img src="{{ $o->animalDetails->animalMainPhoto?->url }}" class="card-img-top" alt="...">
        <div class="card-body ">
            <div class="row" style="height: 100px">
                <p class="card-text">{!! $o->animalDetails->id !!}/{!! $o->animalDetails->name !!} </p>
            </div>
            <div class="row">
                <div class="col-lg-6">ur: {{ $o->animalDetails->date_of_birth }}</div>
                <div class="col-lg-6 text-end">
                    @if ($o->animalDetails->sex == 3)
                        <i class="fa-solid fa-venus fa-2xl text-danger"></i>
                    @elseif ($o->animalDetails->sex == 2)
                        <i class="fa-solid fa-mars fa-2xl text-primary"></i>
                    @else
                        <i class="fa-solid fa-venus-mars fa-2xl"></i>
                    @endif
                </div>
            </div>
            <div class="row ">
                <p class="card-text text-center mt-2"><a href="{{route('profile', ['id' => $o->animalDetails->public_profile_tag])}}" target="_blank">Zobacz profil węża</a></p>
            </div>
        </div>
        <div class="card-footer">
            <table class="detailsTable ">
                <tr>
                    <td><small class=" ">
                        @if (!empty($o->offerReservation->booker))
                            REZERWACJA
                        @elseif ($animalRepo->animalStatus($o->animal_id) == "W trakcie wykarmiania")
                            W trakcie wykarmiania
                        @endif</small></td>
                    <td class="text-end"><small class="text-body-secondary ">CENA: {{$o->price}} zł </small></td>
                </tr>
            </table>
        </div>
    </div>
</div>
