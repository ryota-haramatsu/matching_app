<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // Socialiteの拡張に必要
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Line\LineExtendSocialite@handle',
            // 'SocialiteProviders\Twitter\TwitterExtendSocialite@handle',
            // 'SocialiteProviders\Google\GoogleExtendSocialite',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
