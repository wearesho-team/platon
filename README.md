# Platon Integration
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/platon/v/stable.png)](https://packagist.org/packages/wearesho-team/platon)
[![Total Downloads](https://poser.pugx.org/wearesho-team/platon/downloads.png)](https://packagist.org/packages/wearesho-team/platon)
[![Build Status](https://travis-ci.org/wearesho-team/platon.svg?branch=master)](https://travis-ci.org/wearesho-team/platon)
[![codecov](https://codecov.io/gh/wearesho-team/platon/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/platon)

[Platon](https://platon.ua) integration for PHP.  
[Changelog](./CHANGELOG.md) |
[Usage Examples](./examples/README.md)

## API
- [Docs](https://github.com/wearesho-team/platon/tree/docs)
    - [Integration](https://github.com/wearesho-team/platon/tree/docs/docs/integration_v2.2.pdf)
    - [CardDebitAdvanced](https://github.com/wearesho-team/platon/blob/docs/docs/card_debit_advanced_1.3.pdf)

## Installation
Using composer:
```bash
composer require wearesho-team/platon
```

## Usage

### Configuration
For configuration you have to use [ConfigInterface](./src/ConfigInterface.php).
Available implementations:
- [Config](./src/Config.php) - simple entity. Example:
```php
<?php

use Wearesho\Bobra\Platon;

$config = new Platon\Config("Key", "Pass", "PaymentType");
```
- [EnvironmentConfig](./src/EnvironmentConfig.php) - configuration using getenv. Example:
```php
<?php

use Wearesho\Bobra\Platon;

$config = new Platon\EnvironmentConfig();
```
Environment configuration:

| Variable        | Required | Default                          | Description                   |
|-----------------|----------|----------------------------------|-------------------------------|
| PLATON_KEY      | yes      |                                  | public key                    |
| PLATON_PASS     | yes      |                                  | secret key                    |
| PLATON_URL      | no       | https://secure.platononline.com/ | base url to make C2C requests |
| PLATON_PAYMENT  | no       | CC                               | default payment type          |
| PLATON_LANGUAGE | no       | ua                               | language: `ru` or `ua`        |

### Generating payment configuration

Use [Client](./src/Client.php) to fetch payment config

```php
<?php

use Wearesho\Bobra\Platon;
use Wearesho\Bobra\Payments;

$config = new Platon\EnvironmentConfig();
$client = new Platon\Client($config);

$payment = $client->createPayment(
    new Payments\UrlPair(
        'http://redirect-url-on-success',
        'http://redirect-url-on-fail'
    ),
    new Platon\Transaction(
        $serviceId = 1,
        $amount = 500,
        $paymentType = 'paymentType',
        $description = 'description for payment',
        $ext = [
            0 => 'some-info'            
        ], // optional, will be returned in notification
        $currency = 'UAH', // optional 
        $formId = 'Form id for front-end' // optional
    )
);
```

### Rendering form 

```php
<?php

$config = $payment->jsonSerialize(); // ['action' => 'URL', 'data' => 'url']
```
*You should send `data` to `action` url.

### Notification

Use [Notification\Server](./src/Notification/Server.php) to create payment instance from platon`s request:

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

### Info
Fetching information about account balance.
Use [Info\ConfigInterface](./src/Info/ConfigInterface.php) for configuration.
[EnvironmentConfig](./src/Info/EnvironmentConfig.php) available:

| Variable                | Required | Description                                    |
|-------------------------|----------|------------------------------------------------|
| PLATON_INFO_PUBLIC_KEY  | yes      | Public Key for Info API                        |
| PLATON_INFO_PRIVATE_KEY | yes      | Private Key for Info API                       |

```php
<?php

use Wearesho\Bobra\Platon;

$publicKey = readline("Public Key: ");
$privateKey = readline("Private Key: ");

$config = new Platon\Info\Config($publicKey, $privateKey);
$client = new GuzzleHttp\Client();

$repository = new Platon\Info\Repository($config, $client);

// All items can be converted to string and JSON formats
$responses = $repository->get();
```
See [Info\Response](./src/Info/Response.php) for details.

## Author
- [Wearesho](https://wearesho.com)
- [Alexander Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
