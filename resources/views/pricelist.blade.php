@extends('layouts.app')

@section('content')
<div class="me-5 ms-4" style="margin-top:-30px">
    <div class="card mb-3 bg-dark photobg rounded-1" id="printableAreaPricelist" style="font-size:0.9rem;">
        <div class="card-body">
            <button type="button" onclick="printDiv()" class="btn btn-success rounded-circle editmode">
                <i class="fa-solid fa-print"></i>
            </button>
            <div class="strike mb-2">
                <span style="font-size:0.95rem;">Cennik</span>
            </div>
            <table class="detailsTable w-100 table table-sm" style="font-size:0.75rem;">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>W</td>
                        <td>Nazwa</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offers as $offer)
                        <tr>
                            <td>{{ $offer->animalDetails->id }}</td>
                            <td>{{ $offer->price }}</td>
                            <td>{!! $offer->animalDetails->name !!}</td>
                            <td></td>
                        </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Style tylko do druku --}}
<style>
@media print {
    @page {
        margin: 0;
        size: A4 portrait;
    }

    body * { 
        visibility: hidden !important;
    }

    #printableAreaPricelist, 
    #printableAreaPricelist * {
        visibility: visible !important;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
        color: #000 !important;
    }

    #printableAreaPricelist {
        margin: -80px 0 0 0 !important;  /* ujemny margines od góry */
        padding: 0.5rem !important;
        background: #fff !important;
        color: #000 !important;
        box-shadow: none !important;
        border: none !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    #printableAreaPricelist .card,
    #printableAreaPricelist .card-body,
    #printableAreaPricelist .detailsTable,
    #printableAreaPricelist .detailsTable td,
    #printableAreaPricelist .detailsTable th,
    #printableAreaPricelist .strike span {
        background: #fff !important;
        color: #000 !important;
        border-color: #000 !important;
    }
}
</style>

<script>
function printDiv() {
    window.print();
}
</script>
@endsection
