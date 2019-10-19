<?php

namespace Framework;

use Illuminate\Support\Str;

class Core
{
    public function setReporting()
    {
        if (Framework::getInstance()->getConfig('debug') === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', LOG_DIR . 'error.log');
        }
    }

    public function route($dispatcher)
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                header('HTTP/1.1 404 Not Found');
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header('HTTP/1.1 405 Method Not Allowed');
                echo 'we\'re sorry about that.';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                if (is_callable($handler)) {
                    $handler();
                }
                if (is_string($handler) && Str::contains($handler, '@')) {
                    $target = explode('@', $handler);
                    $controller = $target[0];
                    $method = $target[1];
                    $controller = new $controller;
                    $controller->$method();
                }
                break;
        }
    }
}
