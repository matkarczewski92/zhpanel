<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body text-center" style="">
      @isset($actual->animalMainPhoto->url)
           <a href="#" data-bs-toggle="modal" data-bs-target="#photo_profil"><img src="{{ $actual->animalMainPhoto->url }}" class="img-fluid " alt="" style="max-height:300px"></a>
       @endisset
   </div>
</div>
<div class="modal fade" id="photo_profil" tabindex="-1" aria-labelledby="photo_profil" aria-hidden="true">
   <div class="modal-dialog modal-xl ">
     <div class="modal-content bg-dark photobg">
       <div class="modal-header border-0" >
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
       <div class="modal-body" style="top: -25px">
           <a href="#" data-bs-dismiss="modal"><img src="{{ $actual->animalMainPhoto?->url }}" class="img-fluid " alt=""></a>
       </div>

     </div>
   </div>
 </div>
