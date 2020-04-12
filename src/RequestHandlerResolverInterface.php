<?php

namespace LoneCat\Router;

interface RequestHandlerResolverInterface
{

    public function resolve($request_handler_id): \Psr\Http\Server\RequestHandlerInterface;
    
}