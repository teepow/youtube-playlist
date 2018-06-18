<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Playlist;

class PlaylistController extends Controller
{
    public function store()
    {
        $playlist = new Playlist();

        $playlist->user_id = AuthController::getAuthenticatedUser()->id;

        $playlist->video_ids = request('video_ids');

        $playlist->name = request('playlist_name');

        $playlist->save();

        return response()->json(['success' => 'success'], 200);
    }

    public function index()
    {
        $user = AuthController::getAuthenticatedUser();

        $playlists = $user->playlists;

        return $playlists;
    }

    public function destroy($playlist_id)
    {
        Playlist::destroy($playlist_id);

        return response()->json(['success' => 'success'], 200);
    }
}
