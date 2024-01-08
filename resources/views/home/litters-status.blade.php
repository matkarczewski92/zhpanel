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
                    {{ $lsL->litter_code }} ({{$layingDay}}),
                @endforeach
         </div>


        <div class="strike mb-2 text-success">
            <span class="text-danger">W trakcie inkubacji</span>
         </div>
         <div>
            @foreach ($littersStatus['hatching'] ?? [] as $lsH)
            @php
                $hatchlingday = date('Y-m-d', strtotime($lsH->connection_date.' + '.systemConfig('layingDuration') + systemConfig('hatchlingDuration').' day'));
            @endphp
                {{ $lsH->litter_code }} ({{$hatchlingday}}),
            @endforeach
         </div>
    </div>
</div>
