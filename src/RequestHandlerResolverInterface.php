<?php

namespace LoneCat\Router;

use Psr\Http\Server\RequestHandlerInterface;

interface RequestHandlerResolverInterface
{

    public function resolve($request_handler_id): RequestHandlerInterface;
    
}