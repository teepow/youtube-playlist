@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">

                    @if(!empty($folders))
                        @include('partials.side-nav')
                    @endif

                    <li class="nav-item">
                        <form class="form-inline" method="post" action="/folders">
                            {{ csrf_field() }}
                            <small id="emailHelp" class="form-text text-muted">create new folder</small>
                            <div class="form-group">
                                <input type="text" class="form-control" id="folder_name" name="folder_name" placeholder="folder name..."><br>

                                <button type="submit" class="btn btn-secondary mb-2">add</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

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

