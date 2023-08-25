<?php

namespace App\Providers;

use App\Events\ContactMailEvent;
use App\Events\NewSocialiteUserEvent;
use App\Events\NewUserEvent;
use App\Events\ReinitPwdEvent;
use App\Listeners\ContactMailListener;
use App\Listeners\NewSocialiteUserListener;
use App\Listeners\NewUserListener;
use App\Listeners\ReinitPwdListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Keycloak\KeycloakExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        NewSocialiteUserEvent::class => [
            NewSocialiteUserListener::class,
        ],
        ContactMailEvent::class => [
            ContactMailListener::class,
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
