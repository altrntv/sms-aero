<?php

use NotificationChannels\SmsAero\Tests\Support\TestNotifiable;
use NotificationChannels\SmsAero\Tests\Support\TestNotification;

it('can send a notification', function () {
    $this->smsAero->shouldReceive('send')
        ->with(Mockery::any())
        ->once();

    $this->channel->send(new TestNotifiable, new TestNotification);
});
