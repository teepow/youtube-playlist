<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subscription;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return /dashboard view
     */
    public function index()
    {
        $user = $this->getAuthenticatedUser();

        $folders = $user->folders;

        $playlist_id = session('playlist_id');

        $user_id = $user->id;

        $no_folder_subscriptions = $user->subscriptions()->whereNull('folder_id')->get();

        return response()->json(compact('folders', 'no_folder_subscriptions', 'playlist_id', 'user_id'));

        //return view('dashboard', compact('folders', 'no_folder_subscriptions', 'playlist_id'));
    }

    /**
     * Show videos for a subscription
     *
     * @param $subscription_id
     *
     * @return /dashboard view with folders, channels which do not have a folder, and videos
     */
    public function show($subscription_id)
    {
        $channel_id = Subscription::where('id', $subscription_id)->value('channel_id');

        $ytc = new YouTubeController();

        $videos = $ytc->getVideos($channel_id);

        $user = Auth::user();

        $folders = $user->folders;

        $no_folder_subscriptions = $user->subscriptions()->whereNull('folder_id')->get();

        return view('dashboard', compact('folders', 'no_folder_subscriptions', 'videos'));
    }

    // somewhere in your controller
    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return $user;
    }

}
