<div>
    <div class="card mb-3 mt-4 bg-dark photobg rounded-1">
        <button type="button" wire:click="editModeSwitch" class="btn btn-{{$editBtnMode}} rounded-circle editmode">
            <i class="fa-solid fa-pen"></i>
        </button>
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Zimowanie</span>
            </div>

            @if ($winterings->count() == 0)
                <div class="strike mb-2">
                    <span>Zimowanie nie zostało zaplanowane</span>
                </div>
            @else
            <table class="detailsTable">
                <tr>
                    <td style="width:25%">Czas trwania</td>
                    <td class="text-center" style="width: 10%">Czas trwania</td>
                    <td class="text-center">Start</td>
                    <td class="text-center">Koniec</td>
                    <td></td>
                </tr>
                @foreach ($winterings as $winter)
                @php
                    $todayDate = date("Y-m-d");
                    $startDate = $winter->start_date ?? $winter->planned_start_date ?? $todayDate;
                    $endStage = $winter->end_date ?? $winter->planned_end_date;
                @endphp
                        <tr>
                            <td>{{ $winter->stageDetails->order }} - {{ $winter->stageDetails->title }}</td>
                        @if($editModeStageId == $winter->id)
                        <form>
                            <td>
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control" wire:model="editCustomDuration">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="date" class="form-control" wire:model="editStartDate">
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="date" class="form-control" wire:model="editEndDate">
                                    <button type="submit" class="btn btn-success" wire:click="editStage">Zapisz</button>
                                </div>
                            </td>
                        </form>
                        @else
                            <td class="@if(!$winter->start_date) text-secondary @endif text-center" >{{ $winter->custom_duration ?? $winter->stageDetails->duration }}</td>
                            <td class="@if(!$winter->start_date) text-secondary @endif text-center" >{{ $winter->start_date ?? $winter->planned_start_date }}</td>
                            <td class="@if(!$winter->end_date) text-secondary @endif text-center">{{ $winter->end_date ?? $$winter->planned_end_date }}</td>
                        @endif
                            <td class="text-end">
                                <button class="btn btn-sm" type="submit" wire:click.prevent="editModeStage({{$winter->id}})"><i class="bi bi-pencil-fill text-warning "></i></button>
                                <button class="btn btn-sm" type="submit" wire:click="startStage({{$winter->id}})"><i class="bi bi-play-circle-fill text-success"></i></button>
                                <button class="btn btn-sm" type="submit" wire:click="endStage({{$winter->id}})"><i class="bi bi-stop-circle-fill text-danger"></i></button>
                                <button class="btn btn-sm" type="submit" wire:click="stageDelete({{$winter->id}})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                @endforeach
            </table>
            @endif
            @if ($editMode!=0)
            <div class="strike mb-2 mt-4">
                <span>Opcje zimowania</span>
            </div>
            @if ($winterings->count() == 0)
                <button class="btn btn-success" wire:click="openWintering({{$animalId}})">Utwórz zimowanie</button>
            @endif
                <button class="btn btn-warning" wire:click="closeWintering({{$animalId}})">Zakończ zimowanie</button>
                <button class="btn btn-danger" wire:click="deleteWintering({{$animalId}})">Usuń zimowanie</button>
                <button class="btn btn-primary" wire:click="updateDates({{$animalId}})">Aktualizuj daty</button>
            @endif
        </div>
    </div>

</div>
