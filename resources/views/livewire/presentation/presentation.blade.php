<div>
    <div class="container-fluid" style="margin-top:-40px">
        <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
            <div class="card-body " style="">
                <div class="strike mb-2">
                    <span>Tryb Prezentacji
                        @if ($step==2)
                            : {{$index}}/{{$animalCount}}
                        @endif
                    </span>
                </div>

                @if ($step == 1 OR $step == '')
                    @include('livewire.presentation.first-step')
                @elseif ($step == 2)
                    @include('livewire.presentation.second-step')
                @endif
            </div>
        </div>
    </div>
    @include('livewire.presentation.components.bottom-buttons')
</div>
