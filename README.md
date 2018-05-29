# Platon Integration
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/platon/v/stable.png)](https://packagist.org/packages/wearesho-team/platon)
[![Total Downloads](https://poser.pugx.org/wearesho-team/platon/downloads.png)](https://packagist.org/packages/wearesho-team/platon)
[![Build Status](https://travis-ci.org/wearesho-team/platon.svg?branch=master)](https://travis-ci.org/wearesho-team/platon)
[![codecov](https://codecov.io/gh/wearesho-team/platon/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/platon)

[Platon](https://platon.ua) integration for PHP.
[Changelog](./CHANGELOG.md)

## Installation
Using composer:
```bash
composer require wearesho-team/platon
```

### Usage

Configure your environment

```dotenv
PLATON_KEY=your_key
PLATON_PASS=your_pass
PLATON_URL=http://custom-url-to-platon.com/
PLATON_PAYMENT=CC
PLATON_LANGUAGE=ru|ua

```

Set up config

```php
<?php

$config = new \Wearesho\Bobra\Platon\EnvironmentConfig();

```

Use [client](./src/Client.php) to create payment instance

```php
<?php

$client = new \Wearesho\Bobra\Platon\Client($config);

$payment = $client->createPayment(
    new \Wearesho\Bobra\Payments\UrlPair(
        'http://redirect-url-on-success',
        'http://redirect-url-on-fail'
    ),
    new \Wearesho\Bobra\Platon\Transaction(
        1, // service id,
        500, // amount
        'paymentType', // your custom payment type
        'description for payment',
        [
            '' // custom payment data (will be returned in callback in ext1, ext2 etc.            
        ],
        'UAH', // currency
        'Form id for front-end'
    )
);

```

Get payment configuration for front-end

```php
<?php

$config = $payment->jsonSerialize();

```

Create iframe in front-end and pass all returned data to it.

### Notification

Use [notification handler](./src/Notification/Server.php) to create payment instance from platon`s request:

```php
<?php

use Wearesho\Bobra\Platon;

class PlatonController
{
    public function actionHandle()
    {
        // You can use several platon configs in different cases.
        // Handler will get that one that matches `key` param from platon`s request.
        // All platon configs should be passed into ConfigProvider.
        $configProvider = new Platon\Notification\ConfigProvider([
            new Platon\Config('First key', 'first pass', 'CC'),    
            new Platon\Config('Second key', 'second pass', 'CC'),    
        ]);

        $server = new Platon\Notification\Server($configProvider);

        try {
            $payment = $server->handle($_POST);   
        } catch (Platon\Notification\InvalidSignException $exception) {
            // handle invalid sign
        } catch (\InvalidArgumentException $exception) {
            // When received data is incorrect or some required fields are empty
        }

        // You can use returned Payment instance to save transaction data.
    }
}

```

## Author
- [Wearesho](https://wearesho.com)
- [Alexander Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
