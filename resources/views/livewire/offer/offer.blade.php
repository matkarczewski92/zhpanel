<div class="container-fluid">
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>{{ $title }}</span>
             </div>

             <table class="detailsTable">
                <tr>
                    <td colspan="5" class="text-center">Dane węża</td>
                    <td colspan="2" class="text-center">Rezerwacja</td>
                    <td></td>
                </tr>
                <tr class="border-bottom">
                    <td>Kod miotu</td>
                    <td>Zwierzę</td>
                    <td>Płeć</td>
                    <td>Cena</td>
                    <td>Data</td>
                    <td class="border-start text-center">Rezerwujący</td>
                    <td class="border-end text-center">Data rezerwacji</td>
                    <td class="text-center">Opcje</td>
                </tr>
                @foreach ($offers as $o)
                    <tr>
                        <td>{!!$o->animalDetails->animalLitter?->litter_code!!}</td>
                        <td><a href="{{ route('animal.profile', $o->animalDetails->id) }}">{!!$o->animalDetails->name!!}</a></td>
                        <td>{{$repo->sexName($o->animalDetails->sex)}} </td>
                        <td>{{$o->price}} zł</td>
                        <td>{{$o->created_at->format("Y-m-d")}}</td>
                        <td class="border-start text-center">{{$o->offerReservation->booker ?? ''}}</td>
                        <td class="border-end text-center">{{$o->offerReservation->expiration_date ?? ''}}</td>
                        <td class="text-center">
                            <a wire:click="publicProfileSwitch({{$o->animalDetails->id}})" class="nav-link py-3 rounded-0 fa-lg" title="Profil publiczny">
                                @if($o->animalDetails->public_profile == 0 ) <i class="fa-regular fa-eye-slash  fa-lg" style="color: #c5cad3;"></i> @else
                                <i class="fa-regular fa-eye " style="color: #297f3f;"></i>
                                @endif
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr class="border-top">
                    <td colspan="2"></td>
                    <td colspan="6">{{ $sum }} zł</td>
                    <td colspan="3"></td>
                </tr>
             </table>
                </div>
            </div>

</div>
