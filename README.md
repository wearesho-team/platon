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

## Usage

See [bobra-payments](https://github.com/wearesho-team/bobra-payments) to configure environment

## Notification

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
        $payment = $server->handle($_POST);

        // You can use returned Payment instance to save transaction data.
    }
}

```

## Author
- [Wearesho](https://wearesho.com)
- [Alexander Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
