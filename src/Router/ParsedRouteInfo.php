<?php

namespace LoneCat\Router\Router;

class ParsedRouteInfo
{

    protected string $route_pattern;
    protected array $vars;

    public function __construct(string $route_pattern, array $vars)
    {
        $this->route_pattern = $route_pattern;
        $this->vars = $vars;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function getRoutePattern(): string
    {
        return $this->route_pattern;
    }

}