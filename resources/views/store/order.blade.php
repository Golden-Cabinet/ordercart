@extends('store.layouts.main')
@section('content')

<div class="home_container" id="home_title_container">
        <a id="home"></a>
        <div id="home-logo-container">
            <img src="/assets/images/golden-cabinet-logo.svg">
            <h2 class='text-center'>Herbs. Service. Community.</h2>
        </div>
        
    </div>
    <div class="home_quote_container">
        <div class="home_quote_inner">
            <div class="home_quote_container_left">
                <i>"I feel like I'm part of this amazing team that cares about what happens to me and takes my health and my well-being very personally.  Everyone at Golden Cabinet makes you feel welcome and relaxed and they're just so compassionate from the minute you walk in the door you feel like you just belong."</i>
            </div>
            <div class="home_quote_container_right">
                Leah Smith
            </div>
        </div>
    </div>
            <div class="clear"></div>
    </div>

@push('js')

@endpush
@endsection