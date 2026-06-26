<?php

namespace NotificationChannels\SmsAero\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Mockery;
use NotificationChannels\SmsAero\SmsAeroApi;
use NotificationChannels\SmsAero\SmsAeroChannel;
use NotificationChannels\SmsAero\SmsAeroServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        App::singleton(SmsAeroApi::class, function () {
            return Mockery::mock(SmsAeroApi::class);
        });

        $this->smsAero = app(SmsAeroApi::class);

        $this->channel = new SmsAeroChannel($this->smsAero);
    }

    /**
     * @param Application $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            SmsAeroServiceProvider::class
        ];
    }
}
