<?php
namespace Zhil\UdpNotifier\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;

class UdpNotifierClientProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zhil.udp_notifier.client'] = $app->share(function () use ($app) {
            return new \Zhil\UdpNotifier\Notifier(
                $app['zhil.udp_notifier.options']["ip"],
                $app['zhil.udp_notifier.options']["port"],
                $app['zhil.udp_notifier.options']["secret"]);
        });
    }

    public function boot(Application $app)
    {
    }
}