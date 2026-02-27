<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FaqModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

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
        // Faqat dashboard sahifasi uchun FAQni ulash
        View::composer('admin.dashboard', function ($view) {
            $view->with('faq', FaqModel::all());
        });

        Event::listen(Login::class, function ($event) {
            $event->user->increment('login_count');
        });
    }
}
