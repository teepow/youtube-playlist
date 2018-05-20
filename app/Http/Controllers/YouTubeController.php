<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;

/**
 * Class YouTubeController
 * @package App\Http\Controllers
 */
class YouTubeController extends Controller
{

    /**
     * @return /dashboard view
     */
    public function index()
    {
        $url = request('url');

        $channelId = $this->getChannelId($url);

        $channel = $this->getChannel($channelId);

        $videos = $this->getVideos($channelId);

        return view('dashboard', compact('channel', 'videos'));
    }

    /**
     * @param string $channelId  Id for channel
     *
     * @return array
     */
    public function getVideos($channelId)
    {
        $videoList = Youtube::listChannelVideos($channelId, 10);

        $i = 0;
        foreach($videoList as $video) {
            $videoId = $video->id->videoId;
            $videos[$i]['thumbnail'] = Youtube::getVideoInfo($videoId)->snippet->thumbnails->high->url;
            $videos[$i]['title'] = Youtube::getVideoInfo($videoId)->snippet->title;
            $videos[$i]['description'] = Youtube::getVideoInfo($videoId)->snippet->description;
            $videos[$i]['id'] = $videoId;
            $i++;
        }

        return $videos;
    }

    /**
     * @param string $channelId Id for channel
     *
     * @return array
     */
    private function getChannel($channelId)
    {
        $channelData = Youtube::getChannelById($channelId);

        $channel['banner'] = $channelData->snippet->thumbnails->medium->url;

        $channel['title'] = $channelData->snippet->title;

        $channel['description'] = $channelData->snippet->description;

        $channel['id'] = $channelData->id;

        return $channel;

    }

    /**
     * @param string $url url for youtube channel
     *
     * @return bool|string
     */
    private function getChannelId($url)
    {
        if(strpos($url, 'user') != false) {
            $username = substr($url, strrpos($url, '/') + 1);

            $channelId = $this->getChannelIdByUsername($username);
        } else {
            $channelId = substr($url, strrpos($url, '/') + 1);
        }

        return $channelId;
    }

    /**
     * @param $username username for youtube channel
     *
     * @return string
     */
    private function getChannelIdByUsername($username)
    {
        $channelData = Youtube::getChannelByName($username);

        $channelId = $channelData->id;

        return $channelId;
    }
}
