<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Mioty</span>
        </div>
            <table class="detailsTable">

                <tr>
                    <td><div class="strike mb-2 text-warning"><span>Zrealizowane</span></div></td>
                </tr>
                <tr>
                    <td>
                    @foreach ($litters as $lt)
                        @if ($lt->category == 4)
                            <a href="{{route('litters.show', $lt->id)}}" class="me-2">{{$lt->litter_code}} </a>
                        @endif
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td><div class="strike mb-2 text-danger"><span>W realizacji</span></div></td>
                </tr>
                <tr>
                    <td>
                    @foreach ($litters as $lt)
                        @if ($lt->category == 1)
                            <a href="{{route('litters.show', $lt->id)}}" class="me-2">{{$lt->litter_code}} </a>
                        @endif
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <td><div class="strike mb-2 text-secondary"><span>Planowane</span></div></td>
                </tr>
                <tr>
                    <td>
                    @foreach ($litters as $lt)
                        @if ($lt->category == 2)
                           <a href="{{route('litters.show', $lt->id)}}" class="me-2">{{$lt->litter_code}} </a>
                        @endif

                    @endforeach
                    </td>
                </tr>

            </table>

    </div>
</div>
