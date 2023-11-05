@extends('layouts.app')

@section('content')
<div class="row ms-2 me-1 mb-5">
    <div class="col col-1" style="width: 5.5rem;">
        <div>
            <div class="d-flex flex-column flex-shrink-0 text-bg-dark mb-1 rounded sidemenu ">
                <ul class="nav nav-pills nav-flush flex-column mb-auto text-center ">
                    <li>
                        <a href="{{ route('feeds.index') }}" class="nav-link py-3 rounded-0" aria-current="page" title="Wróć">
                            <i class="fa-solid fa-circle-arrow-left fa-xl" style="color: #297f3f;"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="col " style="margin-top: -20px">
        <div class="row">
            <div class="col-lg-4">
                @include('feed.profile.feed-profile-edit')
            </div>
            <div class="col-lg-4">
                @include('feed.profile.feed-profile-animals')
            </div>
            <div class="col-lg-4">
                @include('feed.profile.feed-profile-purchase-history')
            </div>
        </div>
    </div>
</div>
@endsection


