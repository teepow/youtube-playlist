
<button type="button" class="btn btn-no-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span id="folder_name">{{ $subscription->title }} </span>
</button>
<div class="dropdown-menu">
    <a class="dropdown-item" href="/dashboard/{{ $subscription->id }}">Show videos</a>
    <h6 class="dropdown-header">Move to folder</h6>
    @foreach($folders as $dropdown_folder)
        @if($dropdown_folder->id != $nav_folder->id)
            <a class="dropdown-item" href="/subscriptions/{{ $subscription->id }}/{{ $dropdown_folder->id }}/edit">{{ $dropdown_folder->name }}</a>
        @endif
    @endforeach
</div>
