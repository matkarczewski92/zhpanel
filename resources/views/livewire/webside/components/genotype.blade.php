<div class="card mb-3 mt-4 bg-dark photobg rounded-1">

    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Genetyka</span>
         </div>
         <div class="row mb-2">
            <div class="col-lg"><div class="strike mb-1 text-secondary"><span>Vis</span></div>
                @foreach ($animal->animalGenotype->where('type', 'v') as $vis)
                {{$vis->genotypeCategory->name}},
                @endforeach
            </div>
            <div class="col-lg"><div class="strike mb-1 text-warning"><span>Het</span></div>
                @foreach ($animal->animalGenotype->where('type', 'h') as $het)
                {{$het->genotypeCategory->name}},
                @endforeach
            </div>
            <div class="col-lg"><div class="strike mb-1 text-danger"><span>Poss</span></div>
                @foreach ($animal->animalGenotype->where('type', 'p') as $pos)
                {{$pos->genotypeCategory->name}},
                @endforeach
            </div>
        </div>

    </div>
</div>
