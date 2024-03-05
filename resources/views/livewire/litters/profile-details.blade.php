
 @php
    $layingDuration = systemConfig('layingDuration');
    $hatchlingDuration = systemConfig('hatchlingDuration');
    $conDate = $litter->connection_date ?? $litter->planned_connection_date;

    $lD = Carbon\Carbon::parse($conDate);
    $layingDate = $lD->addDays($layingDuration)->format("Y-m-d");
    $hD = Carbon\Carbon::parse($layingDate);
    $hatchingDate = $hD->addDays($hatchlingDuration)->format("Y-m-d");
 @endphp
 <div class="card mb-3 bg-dark photobg rounded-1 h-100">
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Dane miotu {{ $litter->litter_code }}</span>
             </div>
             @error('litterCode') <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@enderror
             <div class="row">
                <div class="col-lg-6">
                    <table class="detailsTable">
                        <tr>
                            <td class="key" >Kategoria</td>
                            <td>@if ($editMode==1)
                                    <select wire:model="category" class="form-select">
                                        <option value="1" @if ($litter->category == 0) selected @endif>Miot</option>
                                        <option value="2" @if ($litter->category == 1) selected @endif>Planowane</option>
                                        <option value="3" @if ($litter->category == 2) selected @endif>Szablon/Możliwe</option>
                                        <option value="4" @if ($litter->category == 3) selected @endif>Zrealizowane</option>
                                    </select>
                                @else {{ $litterRepo->litterCategory($category) }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key" >Status</td>
                            <td>@if ($editMode==1) <input type="text" class="form-control" value="{{$status}}" readonly> @else {{ $status }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Kod miotu</td>
                            <td>@if ($editMode==1) <input type="text" class="form-control" wire:model="litterCode" required> @else {{ $litter->litter_code }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Sezon</td>
                            <td>@if ($editMode==1) <input type="number" min="0" class="form-control" wire:model="season"> @else {{ $litter->season }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Samiec</td>
                            <td>@if ($editMode==1)
                                <select wire:model="parentMale" class="form-select">
                                    @foreach ($animalsMale as $aM)
                                        <option value="{{ $aM->id }}" @if ($aM->id == $litter->parent_male) selected @endif>{!!$aM->name!!}</option>
                                    @endforeach
                                </select>
                                @else  <a href="{{ route('animal.profile', $litter->animalMale->id)}}">{!! $litter->animalMale->name !!}</a> @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Samica</td>
                            <td>@if ($editMode==1)
                                <select wire:model="parentFemale" class="form-select">
                                    @foreach ($animalsFemale as $aF)
                                        <option value="{{ $aF->id }}" @if ($aF->id == $litter->parent_female) selected @endif>{!!$aF->name!!}</option>
                                    @endforeach
                                </select>
                                @else <a href="{{ route('animal.profile', $litter->animalFemale->id)}}">{!! $litter->animalFemale->name !!}</a> @endif</td>
                        </tr>
                        {{-- <tr>
                            <td class="key">Planowany dochód</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="key">Rzeczywisty dochód</td>
                            <td></td>
                        </tr> --}}
                    </table>
                </div>
                <div class="col-lg-6">

                    <table class="detailsTable">
                        <tr>
                            <td class="key">Planowana data łączenia</td>
                            <td>@if ($editMode==1) <input type="date" class="form-control" wire:model="plannedConnectionDate"> @else {{ $litter->planned_connection_date }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Data łączenia</td>
                            <td>@if ($editMode==1) <input type="date" class="form-control" wire:model="connectionDate"> @else {{ $litter->connection_date }} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Data zniosu</td>
                            <td>@if ($editMode==1) <input type="date" class="form-control" wire:model="layingDate"> @else {!! $litter->laying_date ?? '<span class="text-secondary">plan. '.$layingDate.'</span>' !!} @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Data wyklucia</td>
                            <td>@if ($editMode==1) <input type="date" class="form-control" wire:model="hatchingDate"> @else {!! $litter->hatching_date ?? '<span class="text-secondary">plan. '.$hatchingDate.'</span>' !!} @endif</td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr/></td>
                        </tr>
                        <tr>
                            <td class="key">Ilość zniesionych jaj</td>
                            <td>@if ($editMode==1) <input type="number" min="0" class="form-control" wire:model="layingEggsTotal" required> @else {{ $litter->laying_eggs_total ?? 0 }} szt. @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Ilosć jaj do inkubacji</td>
                            <td>@if ($editMode==1) <input type="number" min="0" class="form-control" wire:model="layingEggsOk" required> @else {{ $litter->laying_eggs_ok ?? 0}} szt. @endif</td>
                        </tr>
                        <tr>
                            <td class="key">Ilosć wyklutych</td>
                            <td>@if ($editMode==1) <input type="number" min="0" class="form-control" wire:model="hatchingEggs" required> @else {{ $litter->hatching_eggs ?? 0}} szt. @endif</td>
                        </tr>
                    </table>

                </div>
                @if ($editMode==1)
                <div class="d-grid gap-2 mt-4"> <!-- Here -->
                    <button class="btn btn-success" wire:click="save" type="submit">Zapisz</button>
                    <button class="btn btn-danger mt-3" wire:click="delete" type="submit">Usuń miot</button>
                </div>
                @endif
            </div>
        </div>
    </div>
