<?php

namespace App\Providers;

use App\Http\View\Composers\SidenavComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceAllProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
        {
            View::composer(
                '*',
                SidenavComposer::class
            );
    }
}
