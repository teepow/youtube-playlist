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
        try {
            $channelResponse = $this->getChannelResponse($url);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $snippet = $channelResponse->snippet;

        $channel = $this->getChannelInfo($snippet);

        $channel['id'] = $channelResponse->id;

        return $channel;
    }

    /**
     * Gets 12 videos uploaded by a channel
     *
     * @param string $channelId  Id for channel
     *
     * @return array
     */
    public function getVideos($channelId)
    {
        $videoListResponse = Youtube::listChannelVideos($channelId, 12);

        foreach($videoListResponse as $videoResponse)
            $videos[] = $this->getVideoInfo($videoResponse);

        return $videos;
    }

    private function getVideoInfo($videoResponse)
    {
        $video['thumbnail'] = $videoResponse->snippet->thumbnails->high->url;
        $video['title'] = $videoResponse->snippet->title;
        $video['description'] = $videoResponse->snippet->description;
        $video['id'] = $videoResponse->id->videoId;;

        //truncate description to 100 and add elipsis if string is longer 100 characters
        if(strlen($video['description']) >= 100)
            $video['description'] = substr($video['description'], 0, 100) . '...';

        //truncate title to 55 and add elipsis if string is longer 55 characters
        if(strlen($video['title']) >= 55)
            $video['title'] = substr($video['title'], 0, 55) . '...';

        return $video;
    }

    /**
     * gets the channel's name
     *
     * @param $channel_id
     *
     * @return string name of channel
     */
    public function getChannelName($channel_id)
    {
        $channelData = Youtube::getChannelById($channel_id);

        $name = $channelData->snippet->title;

        return $name;
    }

    /**
     * gets a channel's information
     *
     * @param string $channelId Id for channel
     *
     * @return array
     */
    private function getChannelInfo($snippet)
    {
        $channel['banner'] = $snippet->thumbnails->medium->url;

        $channel['title'] = $snippet->title;

        $channel['description'] = $snippet->description;

        return $channel;

    }

    /**
     * gets a channel's id
     *
     * @param string $url url for youtube channel
     *
     * @return bool|string
     */
    private function getChannelResponse($url)
    {
        if(strpos($url, '/user/') != false) {
            $username = substr($url, strrpos($url, '/') + 1);

            return Youtube::getChannelByName($username);
        } elseif (strpos($url, '/channel/') != false) {
            $channelId = substr($url, strrpos($url, '/') + 1);

            return Youtube::getChannelById($channelId);
        }
            throw new \Exception("Invalid URL");
    }
}
