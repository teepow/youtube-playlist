@foreach($folders as $folder)
    <li class="nav-item">
        <div class="btn-group dropright">
            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span id="folder_name">{{ $folder->name }}</span>
            </button>
            <div class="dropdown-menu">
                @foreach($folder->subscriptions as $subscription)
                    <a class="dropdown-item" href="/dashboard/{{ $subscription->id }}">{{ $subscription->title }}</a>
                @endforeach
            </div>
        </div>
    </li>
@endforeach
@foreach($no_folder_channels as $channel)
    <li class="nav-item d-inline-block">
        <a href="/dashboard/{{ $channel->id }}">{{ $channel->title }} </a>
        <div class="btn-group dropright">
            <a data-toggle="dropdown" class="dropdown-toggle">
                <b class="caret"></b>
            </a>
            <div class="dropdown-menu">
                <h6 class="dropdown-header">Move to folder</h6>
                @foreach($folders as $folder)
                    <a class="dropdown-item" href="/subscriptions/{{ $channel->id }}/{{ $folder->id }}/edit">{{ $folder->name }}</a>
                @endforeach
            </div>
        </div>
    </li>
@endforeach

