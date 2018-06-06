<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index()
    {
        $url = request('url');

        $ytc = new YouTubeController();

        return $ytc->getChannel($url);
    }
}
