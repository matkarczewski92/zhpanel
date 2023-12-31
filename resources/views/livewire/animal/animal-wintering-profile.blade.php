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
                    <td>Czas trwania</td>
                    <td>Start</td>
                    <td>Koniec</td>
                </tr>
                @foreach ($winterings as $winter)
                @php
                    $startDate = $winter->start_date ?? $winter->planned_start_date;
                    $endStage = date('Y-m-d', strtotime($startDate. ' + '.$winter->stageDetails->duration.' days'));
                @endphp

                        <tr>
                            <td>{{ $winter->stageDetails->order }} - {{ $winter->stageDetails->title }}</td>
                            <td class="@if(!$winter->start_date) text-secondary @endif">{{ $winter->start_date ?? $winter->planned_start_date }}</td>
                            <td class="@if(!$winter->end_date) text-secondary @endif">{{ $winter->end_date ?? $endStage }}</td>
                        </tr>

                @endforeach
            </table>
            @endif

        </div>
    </div>

</div>
