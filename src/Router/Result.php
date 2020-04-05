<?php

namespace LoneCat\Router\Router;

use Psr\Http\Server\RequestHandlerInterface;

class Result
{

    protected RequestHandlerInterface $request_handler;
    protected array $middlewares;
    protected array $vars;
    private string $name;

    public function __construct(string $name, RequestHandlerInterface $request_handler, array $middlewares = [], array $vars = [])
    {
        $this->name = $name;
        $this->request_handler = $request_handler;
        $this->middlewares = $middlewares;
        $this->vars = $vars;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRequestHandler(): string
    {
        return $this->request_handler;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

}