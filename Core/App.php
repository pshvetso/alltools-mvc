<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:06
 */

namespace Core;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;


class App
{
    /**
     * Routing
     * 
     * @return void
     * 
     */
    
    public function dispatch() {
        $routes = new RouteCollection();

        $routes->add("product_init_route", new Route(
                '/product/init',
                ['controller' => '\App\Controllers\Product', 'method' => 'init']
            )
        );
        $routes->add("product_getAll_route", new Route(
                '/product/getAll',
                ['controller' => '\App\Controllers\Product', 'method' => 'getAll']
            )
        );
        $routes->add("order_create_route", new Route(
                '/order/create',
                ['controller' => '\App\Controllers\Order', 'method' => 'create']
            )
        );
        $routes->add("order_pay_route", new Route(
                '/order/pay',
                ['controller' => '\App\Controllers\Order', 'method' => 'pay']
            )
        );

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->match($context->getPathInfo());

        $params = $_GET;
        array_shift($params);

        $controller = "{$parameters['controller']}Controller";
        $action = $parameters['method'];
        $ctrlObject = new $controller();
        $ctrlObject->$action($params);

    }
}