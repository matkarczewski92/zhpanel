<div>
    <div class="card mb-3 mt-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Rodzice</span>
             </div>
                <div class="col-lg"><div class="strike mb-1 text-secondary"><span>Ojciec</span></div>
                {!!$animal->animalLitter->animalMale->name!!}
                </div>
                <div class="col-lg"><div class="strike mb-1 text-warning"><span>Matka</span></div>
                {!!$animal->animalLitter->animalFemale->name!!}
                </div>
        </div>
    </div>
</div>
