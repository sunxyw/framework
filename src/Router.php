<?php

namespace Framework;

class Router
{
    private $routes = [];

    public function map(array $methods, $uri, $handler)
    {
        $this->routes[] = [$methods, $uri, $handler];
    }

    public function get($uri, $handler)
    {
        $this->map(['GET'], $uri, $handler);
    }

    public function post($uri, $handler)
    {
        $this->map(['POST'], $uri, $handler);
    }

    public function put($uri, $handler)
    {
        $this->map(['PUT', 'POST'], $uri, $handler);
    }

    public function patch($uri, $handler)
    {
        $this->map(['PATCH', 'POST'], $uri, $handler);
    }

    public function delete($uri, $handler)
    {
        $this->map(['DELETE', 'POST'], $uri, $handler);
    }

    public function build()
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        return $dispatcher;
    }
}
