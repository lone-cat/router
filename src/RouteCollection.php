<?php

namespace LoneCat\Router;

use Exception;

class RouteCollection
{

    protected const methods = ['GET',
                               'POST',
                               'ANY',];

    protected array $routes = [];
    protected RequestHandlerResolverInterface $resolver;
    
    public function __construct(RequestHandlerResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    public function add($methods, string $name, string $pattern, $handler): Route
    {
        if (is_string($methods))
            $methods = [$methods];

        if (!is_array($methods))
            throw new Exception('not valid method type');

        foreach ($methods as $key => $method) {
            if (!in_array($method, self::methods, true))
                throw new Exception('HTTP method "' . $method . '" invalid');
        }
        $route = new Route($name, $methods, $pattern, $handler, $this->resolver);
        $this->routes[] = $route;

        return $route;
    }

    public function getRoutesByMethod(string $method)
    {
        $method = mb_strtoupper($method);
        return array_filter(
            $this->routes,
            function ($val, $key) use ($method) {
                /** @var Route $val */
                return in_array($method, $val->getMethods(), true) || in_array('ANY', $val->getMethods(), true);
            },
            ARRAY_FILTER_USE_BOTH);
    }

}