<?php

namespace NotificationChannels\SmsAero;

use Illuminate\Notifications\Notification;
use NotificationChannels\SmsAero\Exceptions\CouldNotSendNotification;

class SmsAeroChannel
{
    public function __construct(protected SmsAeroApi $api)
    {
    }

    /**
     * @return array<string, mixed>|null
     *
     * @throws CouldNotSendNotification
     */
    public function send(mixed $notifiable, Notification $notification): ?array
    {
        if (!method_exists($notification, 'toSmsAero')) {
            return null;
        }

        /** @var SmsAeroMessage $message */
        $message = $notification->toSmsAero($notifiable);

        if (!$message->hasNumber()) {
            /** @var string|null $number */
            $number = $notifiable->routeNotificationFor('SmsAero', $notification);

            if (is_null($number)) {
                return null;
            }

            $message->number($number);
        }

        return $this->api->send($message);
    }
}
