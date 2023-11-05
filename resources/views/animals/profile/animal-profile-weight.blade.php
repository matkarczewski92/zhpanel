<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Ważenia</span>
         </div>
        @if(!empty($animal->animalWeights[0]))
        <div>{!! $charts->container() !!} </div>
        @else
        <div class="alert alert-warning " role="alert">
            Nie dodano jeszcze żadnego ważenia
        </div>
    @endif
        @livewire('animal.animal-weight', ['animalId' => $animal->id])
    </div>
</div>
{!! $charts->script() !!}

