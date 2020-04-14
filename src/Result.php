<?php

namespace LoneCat\Router;

use Psr\Http\Server\RequestHandlerInterface;

class Result
{

    protected RequestHandlerInterface $request_handler;
    protected $request_handler_id;
    protected array $middlewares;
    protected array $vars;
    private string $name;

    public function __construct(
        string $name,
        $request_handler_id,
        array $middlewares = [],
        array $vars = []
    ) {
        $this->name = $name;
        $this->request_handler_id = $request_handler_id;
        $this->middlewares = $middlewares;
        $this->vars = $vars;
    }

    public function resolveHandler(RequestHandlerResolverInterface $resolver) {
        $this->request_handler =
            $this->request_handler_id instanceof RequestHandlerInterface
                ? $this->request_handler_id
                : $resolver->resolve($this->request_handler_id)
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRequestHandler(): RequestHandlerInterface
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