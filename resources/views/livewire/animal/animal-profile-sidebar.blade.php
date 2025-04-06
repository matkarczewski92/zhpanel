<div>

            <a type="button" class="p-2" title="Karmienie" >
               <i class="fa-solid fa-utensils fa-xl {{$feedIndicator}}" style="color: {{$feedIndicatorColor}};"></i>
                {{-- fa-bounce --}}
            </a>
        
            <a type="button" class="p-2" title="Ważenie" data-id="123">
                <i class="fa-solid fa-scale-unbalanced fa-xl {{ $weightIndicator }}" style="color: {{$weightIndicatorColor}};"></i>
            </a>
        
            <a href="{{ route('animals.edit', $animal->id) }}" class="p-2" aria-current="page" title="Edytuj">
                <i class="fa-solid fa-gear fa-xl" style="color: #c5cad3;"></i>
            </a>
        
            <a type="button"data-bs-toggle="modal" data-bs-target="#animalProfileGallery"  class="p-2" title="Galeria" data-id="123">
                <i class="fa-regular fa-images fa-xl" style="color: #c5cad3;"></i>
            </a>
            <a type="button" data-bs-toggle="modal" data-bs-target="#animalOfferModal" class="p-2" title="Oferta sprzedaży">
                <i class="fa-solid fa-barcode fa-xl" style="color: #c5cad3;"></i>
            </a>
        
            <a wire:click="publicProfileSwitch" class="p-2" title="Profil publiczny">
                @if($animal->public_profile == 0 ) <i class="fa-regular fa-eye-slash fa-xl" style="color: #c5cad3;"></i> @else
                <i class="fa-regular fa-eye fa-xl" style="color: #297f3f;"></i>
                @endif
            </a>
       
            <a type="button" href="{{ route('passport', $animal->id) }}" class="p-2" title="Certyfikat">
                <i class="fa-solid fa-passport fa-xl" style="color: #c5cad3;"></i>
                
            </a>
      
</div>
