<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Wylinki</span>
             </div>
             @if (session()->has('animalMolt'))
             <div class="alert alert-{{ session('animalMoltColor') }} alert-dismissible fade show" role="alert">
                 {{ session('animalMolt') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            @endif
             <table class="detailsTable">
                <tr>
                    <td >Data</td>
                </tr>
                @foreach ($molts as $mt)
                <tr>
                    <td style="width:75%">{{$mt->created_at->format("Y-m-d")}}</td>
                </tr>
                @endforeach
             </table>
             <div style="margin-top: 40px">
                <div class="position-absolute bottom-0 end-0 me-3">
                    {{ $molts->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
