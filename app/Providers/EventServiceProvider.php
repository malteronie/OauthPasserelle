<?php

namespace App\Providers;

use App\Events\NewUserEvent;
use App\Events\ReinitPwdEvent;
use App\Listeners\NewUserListener;
use App\Listeners\ReinitPwdListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Keycloak\KeycloakExtendSocialite;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
            // ... other providers
            KeycloakExtendSocialite::class.'@handle',
        ],
        ReinitPwdEvent::class => [
            ReinitPwdListener::class,
        ],
        NewUserEvent::class => [
            NewUserListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
