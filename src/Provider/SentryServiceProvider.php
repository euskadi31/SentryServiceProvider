<?php
/*
 * This file is part of the SentryServiceProvider.
 *
 * (c) Axel Etcheverry <axel@etcheverry.biz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Euskadi31\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Raven_Client;
use RuntimeException;
use Monolog\Logger;
use Monolog\Handler\RavenHandler;
use Psr\Log\LoggerInterface;

/**
 * Sentry integration for Silex.
 *
 * @author Axel Etcheverry <axel@etcheverry.biz>
 */
class SentryServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $app)
    {
        $app['sentry.options'] = [];

        $levels = [
            'debug'     => Logger::DEBUG,
            'info'      => Logger::INFO,
            'notice'    => Logger::NOTICE,
            'warning'   => Logger::WARNING,
            'error'     => Logger::ERROR,
            'critical'  => Logger::CRITICAL,
            'alert'     => Logger::ALERT,
            'emergency' => Logger::EMERGENCY
        ];

        $app['sentry'] = function($app) {
            if (!isset($app['sentry.options']['dsn']) || empty($app['sentry.options']['dsn'])) {
                throw new RuntimeException('sentry dsn is empty.');
            }

            return new Raven_Client($app['sentry.options']['dsn']);
        };

        $app['monolog'] = $app->extend('monolog', function(LoggerInterface $monolog, $app) use ($levels) {
            $level = Logger::NOTICE;

            if (isset($app['sentry.options']['level']) && isset($levels[$app['sentry.options']['level']])) {
                $level = $levels[$app['sentry.options']['level']];
            }

            $monolog->pushHandler(new RavenHandler($app['sentry'], $level));

            return $monolog;
        });
    }
}
