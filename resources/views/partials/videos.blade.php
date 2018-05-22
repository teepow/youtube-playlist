<div class="row">
    @foreach($videos as  $video)
        <div class="col-md-4 card-deck">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="{{ $video['thumbnail'] }}" alt="Card image cap">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                    </div>
                    <br>
                    <h6 class="card-title"><b>{{ $video['title'] }}</b></h6>
                    <hr>
                    <p class="card-text">{{ $video['description'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
