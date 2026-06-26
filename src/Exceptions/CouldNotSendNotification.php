<?php

namespace NotificationChannels\SmsAero\Exceptions;

use Exception;
use Throwable;

class CouldNotSendNotification extends Exception
{
    public static function serviceNotAvailable(Throwable $exception): self
    {
        return new static(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }

    public static function apiError(int $statusCode, ?string $message): static
    {
        return new static("{$statusCode} Sms Aero API error: {$message}", $statusCode);
    }
}
