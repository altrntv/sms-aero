<?php

use NotificationChannels\SmsAero\Exceptions\CouldNotSendNotification;
use NotificationChannels\SmsAero\SmsAeroApi;
use NotificationChannels\SmsAero\SmsAeroMessage;

it('has config with default', function () {
    $username = 'username';
    $password = 'password';

    config()->set('services.sms-aero.username', $username);
    config()->set('services.sms-aero.password', $password);

    $smsAero = getExtendedSmsAeroApi($username, $password);

    $this->assertEquals([$username, $password], $smsAero->getCredentials());
});

it('can check smspoh responded with error', function () {
    $smsAero = new SmsAeroApi('username', 'password');

    $smsAero->send(
        (new SmsAeroMessage('test', 'test'))
            ->number('9999999999')
    );
})->throws(CouldNotSendNotification::class);

function getExtendedSmsAeroApi(string $username, string $password): SmsAeroApi
{
    return new class($username, $password) extends SmsAeroApi {
        public function getCredentials(): array
        {
            return $this->pendingRequest->getOptions()['auth'] ?? [];
        }
    };
}
