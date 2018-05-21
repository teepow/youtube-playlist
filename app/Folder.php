<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Folder
 * @package App
 */
class Folder extends Model
{
    /**
     * A folder has many subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * A folder has one user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
