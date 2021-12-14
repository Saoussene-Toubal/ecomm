<?php

namespace App\Providers;
use App\Listener\CartUpdetedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        'cart.added' => [
           // 'App\Listener\CartUpdetedListener'
        ],
        'cart.updated' => [
          //  'App\Listener\CartUpdetedListener'
        ],
        'cart.removed' => [
           // 'App\Listener\CartUpdetedListener'
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
