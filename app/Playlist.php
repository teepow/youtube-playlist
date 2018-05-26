<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{

    /**
     * A playlist has one user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder()
    {
        return $this->belongsTo(User::class);
    }
}
