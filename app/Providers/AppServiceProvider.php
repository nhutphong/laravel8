<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\SiteNameComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         View::share('siteTitle', 'Toidicode.com');
         // $siteTitle pass to all view=.php .html. 

         // 
         View::composer('home', SiteNameComposer::class);

    }
}
