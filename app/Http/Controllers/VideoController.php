<?php

namespace App\Http\Controllers;

use App\Subscription;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($subscription_id)
    {
        $channel_id = Subscription::where('id', $subscription_id)->value('channel_id');

        $ytc = new YouTubeController();

        return $ytc->getVideos($channel_id);
    }
}
