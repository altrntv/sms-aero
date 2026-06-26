# Sms Aero notifications channel for Laravel

This package makes it easy to send notifications using [smsaero.ru](https://smsaero.ru) with Laravel.

## Contents

- [Installation](#installation)
    - [Setting up the Sms Aero service](#setting-up-the-sms-aero-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

Install this package with Composer:

```bash
composer require altrntv/sms-aero
```

### Setting up the Sms Aero service

Add your Sms Aero Api ID and Host to your `config/services.php`:

```php
...
'sms-aero' => [
    'username'  => env('SMS_AERO_USERNAME'),
    'password' => env('SMS_AERO_PASSWORD'),
    'host' => env('SMS_AERO_HOST', 'https://gate.smsaero.ru/v2'),
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use NotificationChannels\SmsAero\SmsAeroMessage;
use NotificationChannels\SmsAero\SmsAeroChannel;
use Illuminate\Notifications\Notification;

class OrderStatus extends Notification
{
    public function via(mixed $notifiable): array
    {
        return [
            SmsAeroChannel::class,
            // or
            'sms-aero',
        ];
    }

    public function toSmsAero(mixed $notifiable): SmsAeroMessage
    {
        return SmsAeroMessage::create('Message', 'Sender Name');
    }
}
```

In your notifiable model, make sure to include a `routeNotificationForSmsAero()` method, which returns a phone number or
an array of phone numbers.

```php
public function routeNotificationForSmsAero(): ?string
{
    return $this->phone;
}
```

### Available Message methods

| Method                                   | Description                                                                                                              |
|------------------------------------------|--------------------------------------------------------------------------------------------------------------------------|
| `number(string $number)`                 | Set a phone number.                                                                                                      |
| `dateSend(int $dateSend)`                | The date for the delayed sending of the message in unixtime format.                                                      |
| `callbackUrl(string $callbackUrl)`       | The URL for sending the message status in the format `https://your.site` in response, the system waits for the 200 status. |
| `callbackFormat(string $callbackFormat)` | If `callbackFormat=JSON` is set, data in JSON format will be sent to `callbackUrl`, otherwise `x-www-form-urlencoded` is used. |
| `shortLink(?int $shortLink)`             | If `shortLink=1`, all links will be shortened automatically.                                                               |

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email <sssecularization@gmail.com> instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Pavel Dykin](https://github.com/altrntv)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
