<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>{{ $title }}</span>
             </div>

             <table class="detailsTable">
                <tr class="border-bottom">
                    <td>Kod miotu</td>
                    <td>Zwierzę</td>
                    <td>Cena</td>
                    <td>Data</td>
                    <td>Rezerwacja</td>
                    <td>Publiczna</td>
                </tr>
                @foreach ($offers as $o)
                    <tr>
                        <td>{!!$o->animalDetails->animalLitter?->litter_code!!}</td>
                        <td><a href="{{ route('animal.profile', $o->animalDetails->id) }}">{!!$o->animalDetails->name!!}</a></td>
                        <td>{{$o->price}} zł</td>
                        <td>{{$o->created_at->format("Y-m-d")}}</td>
                        <td>{{$o->offerReservation->booker ?? ''}}</td>
                        <td>
                            <a wire:click="publicProfileSwitch({{$o->animalDetails->id}})" class="nav-link py-3 rounded-0" title="Profil publiczny">
                                @if($o->animalDetails->public_profile == 0 ) <i class="fa-regular fa-eye-slash " style="color: #c5cad3;"></i> @else
                                <i class="fa-regular fa-eye " style="color: #297f3f;"></i>
                                @endif
                            </a>
                        </td>
                    </tr>
                @endforeach
             </table>
                </div>
            </div>

</div>
