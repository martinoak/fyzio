<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forpsi MySQL limitations

        Schema::defaultStringLength(191);

        // Make the current announcement available to the banner partial
        // (included on every page) and to the admin dashboard.
        View::composer(['partials.announcement', 'admin.dashboard'], function ($view) {
            $view->with('announcement', Announcement::current());
        });
    }
}
