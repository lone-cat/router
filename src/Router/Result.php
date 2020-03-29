<?php

namespace LoneCat\Router\Router;

class Result
{

    protected string $request_handler_name;
    protected array $middlewares;
    protected array $vars;
    private string $name;

    public function __construct(string $name, string $request_handler_name, array $middlewares = [], array $vars = [])
    {
        $this->name = $name;
        $this->request_handler_name = $request_handler_name;
        $this->middlewares = $middlewares;
        $this->vars = $vars;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRequestHandlerName(): string
    {
        return $this->request_handler_name;
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