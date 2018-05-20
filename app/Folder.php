<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
