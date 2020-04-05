<?php

namespace LoneCat\Router\Router;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Route
{

    protected string $name;
    protected array $methods;
    protected string $pattern;
    protected string $handler;
    protected array $vars = [];
    protected array $middlewares = [];

    public function __construct(string $name, array $methods, string $pattern, $handler)
    {
        $this->name = $name;
        $this->methods = $methods;
        $this->pattern = $pattern;
        $this->handler = $handler;
    }

    public function match(ServerRequestInterface $request): ?Result
    {
        $result = RouteParser::parse($this->pattern);

        $pattern = $result->getRoutePattern();
        $vars = $result->getVars();

        $path = $request->getUri()
                        ->getPath()
        ;

        if (!preg_match('{^' . $pattern . '$}ui', $path, $hypo_matches))
            return null;

        $matches = [];
        foreach ($vars as $var_name) {
            $matches[$var_name] = $hypo_matches[$var_name] ?? null;
        }

        foreach ($matches as $var_name => $var_value) {
            if (!array_key_exists($var_name, $this->vars))
                throw new Exception('no var type passed!');

            /*
            // Check var type
            if (gettype($var_value) !== $this->vars[$var_name])
                return null;
            */
        }

        return new Result($this->name, $this->getHandler($this->handler), $this->middlewares, $matches);
    }

    protected function getHandler($handler): RequestHandlerInterface
    {
        if ($handler instanceof RequestHandlerInterface)
            return $handler;

        if (is_callable($handler)) {
            return new class() implements RequestHandlerInterface {

                private $handler;

                public function __construct($handler) {
                    $this->handler = $handler;
                }

                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    return ($this->handler)($request);
                }

            };
        }

        if (!class_exists($handler))
            throw new Exception('no route class found');

        if (!is_subclass_of($handler, RequestHandlerInterface::class))
            throw new Exception('class is not handler');

        return new $handler;
    }

    public function addVar(string $name, $type): self
    {
        $this->vars[$name] = $type;
        return $this;
    }

    public function middleware($middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getHandlerClassName(): string
    {
        return $this->handler;
    }

    public function getTokens(): array
    {
        return $this->vars;
    }

}