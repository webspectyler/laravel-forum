<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

	protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function( $builder ){
            $builder->withCount('replies');
        });
    }

    public function path()
    {
    	return '/threads/' . $this->channel->slug . '/' .$this->id;
    }

    public function replies()
    {
    	return $this->hasMany('App\Reply')->withCount('favorites')->with('owner');
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel', 'channel_id');
    }

    public function addReply($reply)
    {
    	$this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

}
