@foreach($folders as $nav_folder)
    <li class="nav-item">
        <div class="btn-group dropright folder">
            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                <span id="folder_name">{{ $nav_folder->name }}</span>
            </button>
        </div>
            @foreach($nav_folder->subscriptions as $subscription)
                <div class="btn-group dropright" style="display: none">
                    @include('partials.subscriptions')
                </div>
            @endforeach
    </li>
@endforeach
@foreach($no_folder_subscriptions as $subscription)
    <li class="nav-item">
        <div class="btn-group dropright">
            @include('partials.subscriptions')
        </div>
    </li>
@endforeach
