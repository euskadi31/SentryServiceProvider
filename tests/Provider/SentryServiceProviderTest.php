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

use Euskadi31\Silex\Provider\SentryServiceProvider;
use Silex\Application;

class SentryServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        $monologMock = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->getMock();

        $monologMock->method('pushHandler');

        $app = new Application;

        $app['monolog'] = function() use ($monologMock) {
            return $monologMock;
        };

        $app->register(new SentryServiceProvider(), [
            'sentry.options' => [
                'dsn' => 'https://foo:bar@app.getsentry.com/46448',
                'level' => 'notice'
            ]
        ]);

        $this->assertTrue(isset($app['sentry.options']));
        $this->assertEquals([
            'dsn' => 'https://foo:bar@app.getsentry.com/46448',
            'level' => 'notice'
        ], $app['sentry.options']);

        $this->assertInstanceOf('Raven_Client', $app['sentry']);

        $app['monolog'];
    }

    /**
     * @expectedException RuntimeException
     */
    public function testEmptyDsn()
    {
        $monologMock = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->getMock();

        $app = new Application;

        $app['monolog'] = function() use ($monologMock) {
            return $monologMock;
        };

        $app->register(new SentryServiceProvider);

        $app['sentry'];
    }
}
