<div>
    <div class="d-flex flex-column flex-shrink-0 text-bg-dark mb-1 rounded sidemenu content-to-hide">
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center ">
            <li>
                <a href="{{ url()->previous() }}" class="nav-link py-3 rounded-0" aria-current="page" title="Wróć">
                    <i class="fa-solid fa-circle-arrow-left fa-xl" style="color: #297f3f;"></i>
                </a>
            </li>

        <li>
            <a type="button" class="nav-link py-3 rounded-0" title="Karmienie" >
               <i class="fa-solid fa-utensils fa-xl {{$feedIndicator}}" style="color: {{$feedIndicatorColor}};"></i>
                {{-- fa-bounce --}}
            </a>
        </li>
        <li>
            <a type="button" class="nav-link py-3 rounded-0" title="Ważenie" data-id="123">
                <i class="fa-solid fa-scale-unbalanced fa-xl {{ $weightIndicator }}" style="color: {{$weightIndicatorColor}};"></i>
            </a>
        </li>
        <li><hr/></li>
        <li>
            <a href="{{ route('animals.edit', $animal->id) }}" class="nav-link py-3 rounded-0" aria-current="page" title="Edytuj">
                <i class="fa-solid fa-gear fa-xl" style="color: #c5cad3;"></i>
            </a>
        </li>
        {{-- <li>
            <a href="#" class="nav-link py-3 rounded-0" title="Dodaj koszt">
                <i class="fa-solid fa-dollar-sign fa-xl" style="color: #c5cad3;"></i>
            </a>
        </li> --}}
        <li>
            <a type="button"data-bs-toggle="modal" data-bs-target="#animalProfileGallery"  class="nav-link py-3 rounded-0" title="Galeria" data-id="123">
                <i class="fa-regular fa-images fa-xl" style="color: #c5cad3;"></i>
            </a>
        </li>
        <li>
            <a type="button" data-bs-toggle="modal" data-bs-target="#animalOfferModal" class="nav-link py-3 rounded-0" title="Oferta sprzedaży">
                <i class="fa-solid fa-barcode fa-xl" style="color: #c5cad3;"></i>
            </a>
        </li>
        <li>
            <a wire:click="publicProfileSwitch" class="nav-link py-3 rounded-0" title="Profil publiczny">
                @if($animal->public_profile == 0 ) <i class="fa-regular fa-eye-slash fa-xl" style="color: #c5cad3;"></i> @else
                <i class="fa-regular fa-eye fa-xl" style="color: #297f3f;"></i>
                @endif
            </a>
        </li>
        </ul>

    </div>

    <div class="row content-to-show mb-5 bg-dark" style="min-height: 30">
        <center><div class="mt-3 mb-3">
                <a href="{{ url()->previous() }}" class="mt-2 me-3 ms-3" aria-current="page" title="Wróć">
                    <i class="fa-solid fa-circle-arrow-left fa-xl" style="color: #297f3f;"></i></a>
                <a type="button" class="me-3 ms-3" title="Karmienie" >
                    <i class="fa-solid fa-utensils fa-xl {{$feedIndicator}}" style="color: {{$feedIndicatorColor}};"></i>{{-- fa-bounce --}}</a>
                     <a type="button" class="me-3 ms-3" title="Ważenie" data-id="123">
                    <i class="fa-solid fa-scale-unbalanced fa-xl {{ $weightIndicator }}" style="color: {{$weightIndicatorColor}};"></i></a>
                 <a href="{{ route('animals.edit', $animal->id) }}" class="me-3 ms-3" aria-current="page" title="Edytuj">
                    <i class="fa-solid fa-gear fa-xl" style="color: #c5cad3;"></i></a>
                 <a type="button"data-bs-toggle="modal" data-bs-target="#animalProfileGallery"  class="me-3 ms-3" title="Galeria" data-id="123">
                    <i class="fa-regular fa-images fa-xl" style="color: #c5cad3;"></i></a>
                 <a type="button" data-bs-toggle="modal" data-bs-target="#animalOfferModal" class="me-3 ms-3" title="Oferta sprzedaży">
                    <i class="fa-solid fa-barcode fa-xl" style="color: #c5cad3;"></i></a>
                <a wire:click="publicProfileSwitch" class="me-3 ms-3" title="Profil publiczny">
                    @if($animal->public_profile == 0 ) <i class="fa-regular fa-eye-slash fa-xl" style="color: #c5cad3;"></i> @else
                    <i class="fa-regular fa-eye fa-xl" style="color: #297f3f;"></i>@endif</a>
                    </div>
        </center>
    </div>
</div>
