# Laravel Notification channel for sending through WhatsApp

## Contents

This package is based on the Laravel notification channels skeleton: https://github.com/laravel-notification-channels/skeleton


## Installation

Install the package from the repository:

`composer require muisit/laravel-whatsapp:dev-master --prefer-dist`

### Setting up the service

The service provider should be loaded automatically. If not, add the service provider to your `app` configuration:

```php
'providers' => [
        ...
        NotificationChannels\WhatsApp\Provider::class,
        ...
    ],    
```

Configure the service using settings in the `config/services.php` file:

```php
    ...
    'whatsapp' => [
    ],
    ...
```

## Usage

This package extends Laravel with a `whatsapp` channel. You can send to this channel by routing your notifications through `whatsapp` in a similar way as e-mail messages are sent. Make sure to add a `via` method to your notification:

```php
    ...
    public function via($notifiable)
    {
        return ['whatsapp'];
    }
    ...
```

The notification should then implement a `toWhatsApp` method that returns a `NotificationChannels\WhatsApp\Message`:

```php
use NotificationChannels\WhatsApp\Message;
    ...
    public function toWhatsApp($notifiable)
    {
        $message = new AwsSmsMessage($body);
        $message->setRecipient($notifiable->routeNotificationFor('whatsapp'));
        return $message;
    }
    ...
```

The notifiable can then implement the `routeNotificationFor` method to return the recipient phone numbers.

You can return a list of `Message` objects to send out several messages at once. This cannot be used to create a group for these numbers and post the message once.

### Available Message methods

The `recipient` should be an international phone number: `+<country code>-<internal country code>`

The `body` of the message contains the WhatsApp text.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email laravel@muisit.nl instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Michiel Uitdehaag](https://github.com/muisit)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
