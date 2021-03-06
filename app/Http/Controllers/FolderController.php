<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use Illuminate\Support\Facades\Auth;

/**
 * Class FolderController
 * @package App\Http\Controllers
 */
class FolderController extends Controller
{
    /**
     * Saves a folder in the database
     *
     * @return redirect back
     */
    public function store()
    {
        $folder = new Folder();

        $folder->name = request('folder_name');

        $folder->user_id = Auth::user()->id;

        $folder->save();

        return $this->index();
    }

    public function index()
    {
        $user = AuthController::getAuthenticatedUser();

        $folders = $user->folders;

        $folders->load('subscriptions');

        return $folders;
    }

    public function destroy($folder_id)
    {
        Folder::destroy($folder_id);

        return $this->index();
    }
}
