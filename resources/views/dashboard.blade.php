@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">

        @include('partials.side-nav')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

            @if(empty($channel) && empty($videos))
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
            @endif

            <div class="album py-5">
                <div class="container">

                    @if(!empty($channel))
                        @include('partials.channel-description')
                    @endif

                    @if(!empty($videos) && empty($channel))
                        @include('partials.videos')
                    @endif

                </div>
            </div>
        </main>
    </div>
</div>

@endsection

