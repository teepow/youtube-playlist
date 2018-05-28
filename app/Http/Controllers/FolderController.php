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

        return back();
    }

    public function index()
    {
        $folders = Folder::all();

        return $folders;
    }
}
