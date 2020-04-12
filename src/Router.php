<?php

namespace LoneCat\Router;

use Psr\Http\Message\ServerRequestInterface;

class Router
{

    protected RouteCollection $collection;
    protected RequestHandlerResolverInterface $resolver;

    public function __construct(RequestHandlerResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        $this->collection = new RouteCollection($this->resolver);
    }

    public function getRouteResult(ServerRequestInterface $request): ?Result
    {
        $method = $request->getMethod();
        $routes = $this->collection->getRoutesByMethod($method);
        foreach ($routes as $route) {
            $result = $route->match($request);
            if ($result)
                return $result;
        }

        return null;
    }

    public function addGet(string $name, string $pattern, $handler): Route
    {
        return $this->collection->add('GET', $name, $pattern, $handler);
    }

    public function addPost(string $name, string $pattern, $handler): Route
    {
        return $this->collection->add('POST', $name, $pattern, $handler);
    }

    public function addAny(string $name, string $pattern, $handler): Route
    {
        return $this->collection->add('ANY', $name, $pattern, $handler_classname);
    }

    public function getRoutesByMethod(string $method)
    {
        return $this->collection->getRoutesByMethod($method);
    }

    public function go(string $rel_path)
    {
        header('Location: ' . $rel_path);
        exit();
    }

    public function reload_page()
    {
        header('Refresh: 0');
        exit();
    }

    public function go_root()
    {
        self::go('/');
    }

}