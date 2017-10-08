<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;

class Reply extends Model
{

	protected $guarded = [];

    public function owner()
    {
		return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorited');
    }

    public function favorite()
    {
        $user_id = auth()->id();
        $attributes = [ 'user_id' => $user_id ];
        if (!$this->isFavoritedBy($user_id)) {
            //die('here: ' . __LINE__ . ' ' );
            $this->favorites()->create($attributes);
        }
    }

    public function isFavoritedBy($user_id)
    {
        return $this->favorites->filter(function($favorite) use ($user_id) {
            return $this->user_id = $user_id;
        })->count() > 0 ;
        //return $this->favorites()->where([ 'user_id' => $user_id ])->exists();
    }
}
