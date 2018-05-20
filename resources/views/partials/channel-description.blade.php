<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <img src="{{ $channel['banner'] }}" class="img-fluid" alt="">
        <h1 class="display-3">{{ $channel['title'] }}</h1>
        <p class="lead">{{ $channel['description'] }}</p>
        <hr class="my-4">
        <p class="lead">
        <form method="post" action="/subscriptions">
            {{ csrf_field() }}
            <input type="hidden" name="channel_id" value="{{ $channel['id'] }}">
            <input type="submit" class="btn btn-primary btn-lg" value="Subscribe">
        </form>
        </p>
    </div>
</div>
