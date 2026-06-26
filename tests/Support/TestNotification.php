<?php

namespace NotificationChannels\SmsAero\Tests\Support;

use Illuminate\Notifications\Notification;
use NotificationChannels\SmsAero\SmsAeroMessage;

class TestNotification extends Notification
{
    public function toSmsAero($notifiable): SmsAeroMessage
    {
        return SmsAeroMessage::create('Text', 'Test');
    }
}
