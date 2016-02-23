<?php
namespace Zhil\UdpNotifier\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;


class UdpNotifierServerProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zhil.udp_notifier.server'] = $app->protect(function ($handler,$banHandler) use ($app) {
            $listener = new \Zhil\UdpNotifier\Listener(
                $app['zhil.udp_notifier.options']["ip"],
                $app['zhil.udp_notifier.options']["port"],
                $app['zhil.udp_notifier.options']["secret"]);
            $listener->run(function($message, $address) use ($app,$handler) {
                if($json = json_decode($message)) {
                    $app[$handler]($json, $address);
                }
            },function($message, $address) use ($app,$banHandler) {
                $app[$banHandler]($message, $address);
            });
        });
    }

    public function boot(Application $app)
    {
        $xdebugPoint = "cant find where is it called?";
    }
}