<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->lineif($notifiable->provider, 'Please update your username: '.$notifiable->username)
                ->lineif($notifiable->provider, 'Please update your password: '.$notifiable->password)
                ->action('Verify Email Address', $url);
        });

//        Model::preventLazyLoading(! $this->app->isProduction());

        Paginator::useBootstrap();
    }


}
