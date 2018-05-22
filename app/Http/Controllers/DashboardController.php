<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subscription;

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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return /dashboard view
     */
    public function index()
    {
        $user = Auth::user();

        $folders = $user->folders;

        $no_folder_channels = $user->subscriptions()->whereNull('folder_id')->get();

        return view('dashboard', compact('folders', 'no_folder_channels'));
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

        $no_folder_channels = $user->subscriptions()->whereNull('folder_id')->get();

        return view('dashboard', compact('folders', 'no_folder_channels', 'videos'));
    }

}
