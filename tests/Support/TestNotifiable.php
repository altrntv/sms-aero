<?php

namespace NotificationChannels\SmsAero\Tests\Support;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public string $phone = '+79999999999';

    public function routeNotificationForSmsAero($notification): string
    {
        return $this->phone;
    }
}
