<div class="card bg-dark photobg rounded-1 h-100 ">
    <div class="card-body" style="">
        <div class="strike mb-2">
            <span>Status miotów</span>
         </div>

        <div class="strike mb-2 text-success">
            <span class="text-warning">Oczekiwanie na wyklucie</span>
         </div>
         <div>
                @foreach ($littersStatus['laying'] ?? [] as $lsL)
                @php
                    $layingDay = date('Y-m-d', strtotime($lsL->connection_date.' + '.systemConfig('layingDuration').' day'));
                @endphp
                    <a href="{{ route('litters.show', $lsL->id)}}">{{ $lsL->litter_code }} ({{$layingDay}}),</a>
                @endforeach
         </div>


        <div class="strike mb-2 text-success">
            <span class="text-danger">W trakcie inkubacji</span>
         </div>
         <div>
            @foreach ($littersStatus['hatching'] ?? [] as $lsH)
            @php
                $hatchlingday = date('Y-m-d', strtotime($lsH->laying_date.' + '.systemConfig('hatchlingDuration').' day'));
            @endphp
                <a href="{{ route('litters.show', $lsH->id)}}">{{ $lsH->litter_code }} ({{$hatchlingday}}),</a>
            @endforeach
         </div>
    </div>
</div>
