<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
//        VerifyEmail::toMailUsing(function ($notifiable, $url) {
//            return (new MailMessage)
//                ->mailer('smtp')
//                ->from('test@example.com', 'test')
//                ->subject('Verify Email Address')
//                ->line('Click the button below to verify your email address.')
//                ->action('Verify Email Address', $url);
//        });
    }
}
