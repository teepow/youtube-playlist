<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Playlist;

define('EMBEDDED_PLAYLIST_URL', 'https://www.youtube.com/embed/video_id?playlist=');

class PlaylistController extends Controller
{
    public function store($playlist_id, $video_id)
    {
        $playlist = new Playlist();

        $playlist->user_id = Auth::user()->id;

        $playlist->video_id = $video_id;

        $playlist->playlist_id = $playlist_id;

        $playlist->save();

        session(['playlist_id' => $playlist_id]);

        return redirect('dashboard');
    }

    public function insert($video_id)
    {
        $user_id = Auth::user()->id;

        $playlist = New Playlist();

        $playlist->user_id = $user_id;

        $playlist->url = EMBEDDED_PLAYLIST_URL . $video_id;

        return back();
    }
}
