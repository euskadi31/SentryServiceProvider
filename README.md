# Silex Sentry Service Provider

[![Build Status](https://img.shields.io/travis/euskadi31/SentryServiceProvider/master.svg)](https://travis-ci.org/euskadi31/SentryServiceProvider)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/0261b1ab-acb6-4d18-b5ec-bb98c3a2edce.svg)](https://insight.sensiolabs.com/projects/0261b1ab-acb6-4d18-b5ec-bb98c3a2edce)
[![Coveralls](https://img.shields.io/coveralls/euskadi31/SentryServiceProvider.svg)](https://coveralls.io/github/euskadi31/SentryServiceProvider)
[![HHVM](https://img.shields.io/hhvm/euskadi31/SentryServiceProvider.svg)](https://travis-ci.org/euskadi31/SentryServiceProvider)
[![Packagist](https://img.shields.io/packagist/v/euskadi31/sentry-service-provider.svg)](https://packagist.org/packages/euskadi31/sentry-service-provider)


## Install

Add `euskadi31/sentry-service-provider` to your `composer.json`:

    % php composer.phar require euskadi31/sentry-service-provider:~1.0

## Usage

### Configuration

```php
<?php

$app = new Silex\Application;

$app->register(new \Euskadi31\Silex\Provider\SentryServiceProvider(), [
    'sentry.options' => [
        'dsn' => 'https://user:pass@'
    ]
]);
```

## License

SentryServiceProvider is licensed under [the MIT license](LICENSE.md).
