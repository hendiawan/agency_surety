<?php

namespace App\Providers;

use View;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class HeaderServiceprovider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        //
        /*
        $sppsb = Sppb::all()->count();
        View::share('myApp',$sppsb);
        View::share('myApp2','20');
        */
        $view->composer('*', 'App\Http\ViewComposers\GlobalComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
