<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="row">
        <div class="col m-1">
        <div class="strike mb-2 mt-2 me-1"><span>Mioty</span></div>

        </div>
    </div>
    <div class="row">
        <div class="col m-1">
            <p class="ms-2 badge-group">
                @foreach ($litters->where('category', '!=', 3)->sortBy('category') as $litter)
                    @php
                        if($litter->category == 4){
                            $color = 'text-bg-success';
                            $tooltip = "Zrealizowane";
                        } elseif($litter->category == 2){
                            $color = 'text-bg-warning';
                            $tooltip = "Planowane";
                        } elseif($litter->category == 1){
                            $color = 'text-bg-danger';
                            $tooltip = "W realizacji";
                        } 
                    @endphp
                    <a href="{{route('litters.show', $litter->id)}}"><span class="badge {{$color}} mt-2" data-bs-toggle="tooltip" data-bs-title="{{$tooltip}}" style="font-size: 10pt;">{{$litter->litter_code}}</span></a>
                @endforeach
            </p>
        </div>
    </div>
    
</div>
