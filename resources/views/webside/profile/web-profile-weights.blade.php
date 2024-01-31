<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="card-body " style="">
    <div class="strike mb-2">
        <span>Ważenia</span>
    </div>
        @if(!empty($animal->animalWeights[0]))

        @else
            <div class="alert alert-warning " role="alert">
            Nie dodano jeszcze żadnego ważenia
            </div>
        @endif
            <div>
        @if(!empty($weightHistory[0]))
            <table class="detailsTable">
                <tr class="border-bottom">
                <td>Data ważenia </td>
                <td>Wartość</td>
                </tr>
                @foreach ($weightHistory as $weight)
                    <tr>
                    <td class="align-middle">{{ date('Y-m-d', strtotime($weight->created_at)) }}</td>
                    <td class="align-middle">{{ $weight->value}} g.</td>
                    </tr>
                @endforeach
                </table>
            <div class="mt-2">
                <div class="position-absolute bottom-0 end-0 me-3">
                {{ $weightHistory->links() }}
                </div>
            </div>
        @endif
    </div>

    </div>
</div>


