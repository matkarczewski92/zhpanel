<div class="row text-center">
    <div class="col-lg-5">
        <span class="h5">{!! $stage->getParentMaleDetails->name ?? $stage->parent_male_name !!}</span><br>
        <sup>Samiec</sup>
    </div>
    <div class="col-lg-2">
@php
$litter = (!is_null($stage->parent_male_id) and !is_null($stage->parent_female_id)) ? App\Models\Litter::where('parent_male', $stage->parent_male_id)->where('parent_female', $stage->parent_female_id)->get() : null;

if(!is_null($litter) AND (!is_null($stage->parent_male_id) and !is_null($stage->parent_female_id)))
{
    if($litter->where('category', 1)->where('season', $stage->season)->first())
    {
        $litterData = $litter->where('category', 1)->where('season', $stage->season)->first();
    } elseif ($litter->where('category', 2)->where('season', $stage->season)->first()) {
        $litterData = $litter->where('category', 2)->where('season', $stage->season)->first();
    }
}

@endphp
    @if (isset($litterData) AND !is_null($litterData))
       <span class="h5"><a href="{{route('litters.show', $litterData->id)}}">{{$litterData->litter_code}}</a></span>

    @endif
    </div>
    <div class="col-lg-5">
        <span class="h5">{!! $stage->getParentFemaleDetails->name ?? $stage->parent_female_name !!}</span><br>
        <sup>Samica</sup>
    </div>
</div>
