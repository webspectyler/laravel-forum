<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Channel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\View::share('channels', Channel::all());
        \View::composer('*', function ($view){
           $allChannels =  \Cache::rememberForever('channels', function(){
                return \App\Channel::all();
            });
            $view->with('channels', $allChannels);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
