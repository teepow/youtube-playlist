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
    public function store()
    {
        $subscription = new Subscription();

        $subscription->channel_id = request('channel_id');

        $subscription->user_id = Auth::user()->id;

        $subscription->folder_id = null;

        $ytc = new YouTubeController();

        $subscription->title = $ytc->getChannelName($subscription->channel_id);

        $subscription->save();

        return redirect('dashboard/' . $subscription->id);
    }

    /**
     * Add subscription to folder.
     * Changes the folder_id of the subscription in the database.
     *
     * @param $subscription_id
     * @param $folder_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($subscription_id, $folder_id)
    {
        $subscription = Subscription::find($subscription_id);

        $subscription->folder_id = $folder_id;

        $subscription->save();

        return back();
    }

    public function noFolder()
    {
        $user = AuthController::getAuthenticatedUser();

        $no_folder_subscriptions = $user->subscriptions()->whereNull('folder_id')->get();

        return $no_folder_subscriptions;
    }
}
