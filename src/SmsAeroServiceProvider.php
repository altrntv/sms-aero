<?php

namespace NotificationChannels\SmsAero;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SmsAeroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        App::when(SmsAeroChannel::class)
            ->needs(SmsAeroApi::class)
            ->give(function (): SmsAeroApi {
                return new SmsAeroApi(
                    config('services.sms-aero.username'),
                    config('services.sms-aero.password'),
                    config('services.sms-aero.host'),
                );
            });
    }

    public function register(): void
    {
        Notification::extend('sms-aero', function (Container $app): mixed {
            return $app->make(SmsAeroChannel::class);
        });
    }
}
