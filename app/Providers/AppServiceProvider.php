<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\StoreSetting;
use Illuminate\Pagination\Paginator;
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
        View::share('storeSetting', StoreSetting::first());

        View::composer('*', function ($view) {
            $user = auth()->user();
            $photoUrl = $user && $user->photo
                ? asset('storage/profile_photos/' . $user->photo)
                : asset('assets/img/profile-img.jpg');
            
            $view->with('photoUrl', $photoUrl);
        });

        Paginator::useBootstrap();
        
    }
}
