<div class="row mt-2">
    <div class="col-lg-1 mt-1">
        <div class="card bg-dark photobg rounded-1 h-100">
            <div class="card-body text-center" style="">
            {{$title}}
            </div>
        </div>
    </div>
    <div class="col-lg mt-1">
        <div class="card bg-dark photobg rounded-1 h-100">
            <div class="card-body text-center text-success" style="">
            @foreach ($connection ?? '' as $con)
                <a href="{{ route('litters.show', $con->id)}}"><i class="bi bi-person-circle"></i></a>
                <a href="?filter={{$con->id}}" data-toggle="tooltip" data-placement="top" title="{{$con->connection_date ?? $con->planned_connection_date }}">{{$con->litter_code}}</a>,
            @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg mt-1">
        <div class="card bg-dark photobg rounded-1 h-100">
            <div class="card-body text-center text-warning" style="">
            @foreach ($laying ?? '' as $con)
            @php
                $layingday = date('Y-m-d', strtotime($con->connection_date ?? $con->planned_connection_date.' + '.systemConfig('layingDuration').' day'));
            @endphp
                <a href="{{ route('litters.show', $con->id)}}"><i class="bi bi-person-circle"></i></a>
                <a href="?filter={{$con->id}}" data-toggle="tooltip" data-placement="top" title="{{$layingday}}">{{$con->litter_code}}</a>,
            @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg mt-1">
        <div class="card bg-dark photobg rounded-1 h-100">
            <div class="card-body text-center text-danger" style="">
            @foreach ($hatchling ?? '' as $con)
            @php
                $hatchlingday = date('Y-m-d', strtotime($con->connection_date ?? $con->planned_connection_date.' + '.systemConfig('layingDuration') + systemConfig('hatchlingDuration').' day'));
            @endphp
                <a href="{{ route('litters.show', $con->id)}}"><i class="bi bi-person-circle"></i></a>
                <a href="?filter={{$con->id}}" data-toggle="tooltip" data-placement="top" title="{{$hatchlingday}}">{{$con->litter_code}}</a>,
            @endforeach
            </div>
        </div>
    </div>
</div>
