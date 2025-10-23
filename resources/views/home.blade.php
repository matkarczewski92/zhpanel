@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5" style="margin-top:-30px !important">
    <div class="row mb-4">
        <div class="col">
            <div class="card bg-dark photobg rounded-1">
                <div class="text-center">
                    <h5 class="m-2">Zarządzanie hodowlą</h5>
                </div>
            </div>
        </div>
    </div>
    @php
        $hasLittersStatus = !empty($littersStatus['laying']) || !empty($littersStatus['hatching']);
    @endphp
    <div class="col-12">
        <div class="row g-3">
            <div class="col-12">
                @include('home.info')
            </div>
            <div class="col-12">
                @include('home.financial-summary', [
                    'summary' => $financeSummary,
                    'years' => $financeYears,
                    'selectedYear' => $financeSelectedYear,
                ])
            </div>
            <div class="col-lg-6 col-12">
                <div class="row g-3">
                    @if ($hasLittersStatus)
                        <div class="col-12">
                            @include('home.litters-status')
                        </div>
                    @endif
                    <div class="col-12">
                        @include('home.to-feed-animals', [
                            'animal' => $animal,
                            'summary' => $summary,
                            'summaryPast' => $summaryPast,
                            'title' => 'Do nakarmienia - W hodowli',
                        ])
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                @include('home.to-feed-animals', [
                    'animal' => $litter,
                    'summary' => $summaryLitters,
                    'summaryPast' => $summaryLittersPast,
                    'title' => 'Do nakarmienia - Mioty',
                ])
            </div>
        </div>
    </div>
</div>
@endsection
