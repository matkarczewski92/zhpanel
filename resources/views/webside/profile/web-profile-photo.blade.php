<div class="card mb-3 @if($animal->animal_category_id == 4) bg-info @else bg-dark @endif photobg rounded-1">
    <div class="card-body">
        @isset($animal->animalGallery)
            <a href="#" 
               data-bs-toggle="modal" 
               data-bs-target="#photo_profil" 
               data-photo-url="{{ $animal->animalGallery->url }}">
               <img src="{{ $animal->animalGallery->url }}" class="img-fluid" alt="">
            </a>
        @endisset
    </div>
</div>

<div class="modal fade" id="photo_profil" tabindex="-1" aria-labelledby="photo_profil" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark photobg">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="top: -25px">
                <a href="#" data-bs-dismiss="modal">
                    <img id="modal-image" src="" class="img-fluid" alt="">
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('photo_profil');
    modal.addEventListener('show.bs.modal', function (event) {
        const triggerLink = event.relatedTarget;
        const photoUrl = triggerLink.getAttribute('data-photo-url');

        const modalImage = modal.querySelector('#modal-image');
        modalImage.src = photoUrl;
    });
</script>

