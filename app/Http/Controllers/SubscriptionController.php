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
     * @return subscriptions with no folder
     */
    public function store()
    {
        $subscription = new Subscription();

        $subscription->channel_id = request('channel_id');

        $user = AuthController::getAuthenticatedUser();

        $subscription->user_id = $user->id;

        $subscription->folder_id = null;

        $ytc = new YouTubeController();

        $subscription->title = $ytc->getChannelName($subscription->channel_id);

        $subscription->save();

        return $this->noFolder();
    }

    /**
     * get user's subscriptions that do not belong to a folder
     *
     * @return subscriptions with no folder
     */
    public function noFolder()
    {
        $user = AuthController::getAuthenticatedUser();

        $no_folder_subscriptions = $user->subscriptions()->whereNull('folder_id')->get();

        return $no_folder_subscriptions;
    }

    /**
     * Delete subscription from database
     *
     * @param $subscription_id
     * @return subscriptions with no folder or all folders
     */
    public function destroy($subscription_id)
    {
        Subscription::destroy($subscription_id);

        return $this->getFoldersAndNoFolderSubsJSON();
    }

    /**
     * Add subscription to folder.
     * Changes the folder_id of the subscription in the database.
     *
     * @param $subscription_id
     * @param $folder_id
     *
     * @return user's folders
     */
    public function edit($subscription_id, $folder_id)
    {
        $this->changeFolder($subscription_id, $folder_id);

        return $this->getFoldersAndNoFolderSubsJSON();
    }

    public function editNoFolder($subscription_id)
    {
        $this->changeFolder($subscription_id, NULL);

        return $this->getFoldersAndNoFolderSubsJSON();
    }

    private function changeFolder($subscription_id, $folder_id)
    {
        $subscription = Subscription::find($subscription_id);

        $subscription->folder_id = $folder_id;

        $subscription->save();

    }

    private function getFoldersAndNoFolderSubsJSON()
    {
        $no_folder_subscriptions =  $this->noFolder();

        $fc = new FolderController();

        $folders = $fc->index();

        return response()->json(compact('no_folder_subscriptions', 'folders'));

    }
}
