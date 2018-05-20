<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers
 */
class SubscriptionController extends Controller
{
    /**
     * @return /dashboard view
     */
    public function index()
    {
        $channel_id = request('channel_id');

        $user_id = \Auth::user()->id;

        $subscription = new \App\Subscription();

        $subscription->channel_id = $channel_id;

        $subscription->user_id = $user_id;

        $subscription->folder_id = null;

        $subscription->save();

        $ytc = new YouTubeController();

        $videos = $ytc->getVideos($channel_id);

        return view('dashboard', compact( 'videos'));
    }
}
