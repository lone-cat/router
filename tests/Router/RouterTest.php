<?php

namespace Tests\Pipeline;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testConstructor(): void
    {
        $router = new \LoneCat\Router\Router(null);
        $router->addGet('a', '/', 'handler');
        $router->addGet('a2', '/{id}', 'handler');

        self::assertTrue($router->generateUrl('a2', ['id' => 2]) === '/2');
    }

}