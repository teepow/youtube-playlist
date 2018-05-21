@foreach($folders as $folder)
    <li class="nav-item">
        <a class="nav-link active" href="#">
            <span data-feather="home"></span>
            {{ $folder->name }} <span class="sr-only">(current)</span>
        </a>
    </li>
@endforeach
