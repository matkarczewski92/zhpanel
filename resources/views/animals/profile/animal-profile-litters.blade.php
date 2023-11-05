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
                    @foreach ($litters as $lt)
                        @if ($lt->category == 4)
                            <td><a href="{{route('litters.show', $lt->id)}}">{{$lt->litter_code}} </a></td>
                        @endif

                    @endforeach
                </tr>
                <tr>
                    <td><div class="strike mb-2 text-danger"><span>W realizacji</span></div></td>
                </tr>
                <tr>
                    @foreach ($litters as $lt)
                        @if ($lt->category == 1)
                            <td><a href="{{route('litters.show', $lt->id)}}">{{$lt->litter_code}} </a></td>
                        @endif

                    @endforeach
                </tr>
                <tr>
                    <td><div class="strike mb-2 text-secondary"><span>Planowane</span></div></td>
                </tr>
                <tr>
                    @foreach ($litters as $lt)
                        @if ($lt->category == 2)
                            <td><a href="{{route('litters.show', $lt->id)}}">{{$lt->litter_code}}</a> </td>
                        @endif

                    @endforeach
                </tr>

            </table>

    </div>
</div>
