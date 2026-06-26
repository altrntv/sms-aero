<?php

namespace NotificationChannels\SmsAero;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, string|int>
 */
class SmsAeroMessage implements Arrayable
{
    protected string $number;

    protected string $sign;

    protected string $text;

    protected ?int $dateSend = null;

    protected ?string $callbackUrl = null;

    protected ?string $callbackFormat = null;

    protected ?int $shortLink = null;

    /**
     * @param string $text The text of the message.
     * @param string $sign Sender's name.
     */
    public function __construct(string $text, string $sign)
    {
        $this->text = $text;
        $this->sign = $sign;
    }

    public static function create(string $text, string $sign): static
    {
        return new static($text, $sign);
    }

    public function number(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function hasNumber(): bool
    {
        return isset($this->number);
    }

    public function dateSend(int $dateSend): static
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    public function callbackUrl(string $callbackUrl): static
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    public function callbackFormat(string $callbackFormat): static
    {
        $this->callbackFormat = $callbackFormat;

        return $this;
    }

    public function shortLink(int $shortLink): static
    {
        $this->shortLink = $shortLink;

        return $this;
    }

    /**
     * @return array<string, string|int>
     */
    public function toArray(): array
    {
        return array_filter([
            'number' => $this->number,
            'sign' => $this->sign,
            'text' => $this->text,
            'dateSend' => $this->dateSend,
            'callbackUrl' => $this->callbackUrl,
            'callbackFormat' => $this->callbackFormat,
            'shortLink' => $this->shortLink,
        ], static function (string|int|null $value): bool {
            return $value !== null;
        });
    }
}
