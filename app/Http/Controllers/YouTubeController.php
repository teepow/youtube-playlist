<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alaouy\Youtube\Facades\Youtube;
use App\Subscription;
use Illuminate\Support\Facades\Auth;

/**
 * Class YouTubeController
 * @package App\Http\Controllers
 */
class YouTubeController extends Controller
{

    /**
     * Gets channel information from channel url
     *
     * A channel contains a banner (image url), title, description, id
     *
     * @return /dashboard view
     */
    public function getChannel($url)
    {
        $channelId = $this->getChannelId($url);

        $channel = $this->getChannelInfo($channelId);

        return $channel;
    }

    /**
     * Gets 10 latest videos uploaded by a channel
     *
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

            //truncate description to 100 and add elipsis if string is longer 100 characters
            if(strlen($videos[$i]['description']) >= 100)
                $videos[$i]['description'] = substr($videos[$i]['description'], 0, 100) . '...';

            //truncate title to 55 and add elipsis if string is longer 55 characters
            if(strlen($videos[$i]['title']) >= 55)
                $videos[$i]['title'] = substr($videos[$i]['title'], 0, 55) . '...';

            $i++;
        }

        return $videos;
    }

    /**
     * gets the channel's name
     *
     * @param $channel_id
     *
     * @return string title of channel
     */
    public function getChannelName($channel_id)
    {
        $channelData = Youtube::getChannelById($channel_id);

        $title = $channelData->snippet->title;

        return $title;
    }

    /**
     * gets a channel's information
     *
     * @param string $channelId Id for channel
     *
     * @return array
     */
    private function getChannelInfo($channelId)
    {
        $channelData = Youtube::getChannelById($channelId);

        $channel['banner'] = $channelData->snippet->thumbnails->medium->url;

        $channel['title'] = $channelData->snippet->title;

        $channel['description'] = $channelData->snippet->description;

        $channel['id'] = $channelData->id;

        return $channel;

    }

    /**
     * gets a channel's id
     *
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
     * gets a channel's id by the channel's username
     *
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
