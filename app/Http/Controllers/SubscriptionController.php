<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Illuminate\Support\Facades\Auth;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers
 */
class SubscriptionController extends Controller
{
    /**
     * Saves a subscription in the database
     *
     * @return /dashboard view
     */
    public function index()
    {
        $subscription = new Subscription();

        $subscription->channel_id = request('channel_id');

        $subscription->user_id = Auth::user()->id;

        $subscription->folder_id = null;

        $subscription->save();

        $ytc = new YouTubeController();

        $videos = $ytc->getVideos($subscription->channel_id);

        return view('dashboard', compact( 'videos'));
    }
}
