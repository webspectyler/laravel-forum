<?php

namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use App\Filters\Filters;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    public function by($username)
    {
        $user = \App\User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        $this->builder->orderBy('replies_count', 'desc');
    }
}
