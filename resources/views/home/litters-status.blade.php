@php
    $layingLitters = $littersStatus['laying'] ?? [];
    $hatchingLitters = $littersStatus['hatching'] ?? [];
@endphp
<div class="card bg-dark photobg rounded-1 h-100">
    <div class="card-body">
        <div class="strike mb-2">
            <span>Status miotów</span>
        </div>

        @if (!empty($layingLitters))
            <div class="strike mb-2 text-success">
                <span class="text-warning">Oczekiwanie na zniesienie</span>
            </div>
            <div class="mb-3">
                @foreach ($layingLitters as $litter)
                    @php
                        $layingDay = date('Y-m-d', strtotime($litter->connection_date . ' + ' . systemConfig('layingDuration') . ' day'));
                    @endphp
                    <a href="{{ route('litters.show', $litter->id) }}">{{ $litter->litter_code }} ({{ $layingDay }})</a>@if (!$loop->last), @endif
                @endforeach
            </div>
        @endif

        @if (!empty($hatchingLitters))
            <div class="strike mb-2 text-success">
                <span class="text-danger">W trakcie inkubacji</span>
            </div>
            <div>
                @foreach ($hatchingLitters as $litter)
                    @php
                        $hatchlingDay = date('Y-m-d', strtotime($litter->laying_date . ' + ' . systemConfig('hatchlingDuration') . ' day'));
                    @endphp
                    <a href="{{ route('litters.show', $litter->id) }}">{{ $litter->litter_code }} ({{ $hatchlingDay }})</a>@if (!$loop->last), @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
