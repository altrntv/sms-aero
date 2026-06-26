<?php

namespace NotificationChannels\SmsAero;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use NotificationChannels\SmsAero\Exceptions\CouldNotSendNotification;
use SensitiveParameter;
use Throwable;

class SmsAeroApi
{
    protected const string BASE_URL = 'https://gate.smsaero.ru/v2';

    protected PendingRequest $pendingRequest;

    public function __construct(
        #[SensitiveParameter] string $username,
        #[SensitiveParameter] string $password,
        ?string                      $url = null,
    )
    {
        $this->pendingRequest = Http::createPendingRequest()
            ->baseUrl($url ?? self::BASE_URL)
            ->withBasicAuth($username, $password)
            ->acceptJson()
            ->timeout(5);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws CouldNotSendNotification
     */
    public function send(SmsAeroMessage $message): array
    {
        try {
            $response = $this->pendingRequest
                ->asForm()
                ->post('/sms/send', $message->toArray());
        } catch (Throwable $exception) {
            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }

        if ($response->failed()) {
            throw CouldNotSendNotification::apiError($response->status(), $response->json('message'));
        }

        if ($response->json('success') === false) {
            throw CouldNotSendNotification::apiError($response->status(), $response->json('message'));
        }

        return $response->json(default: []);
    }
}
