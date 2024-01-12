<div class="strike mt-2">
    <span>Wylinka @if($lastMolt?->created_at!=null) (ost. {{date_format($lastMolt->created_at,"Y-m-d")}} ) @endif</span>
</div>

<form wire:submit="addMolt">
    <button type="submit" class="btn btn-sm btn-success m-2 w-100" >Dodaj wylinke</button>
</form>
