<?php

namespace Framework;

use Exception;
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
                echo '抱歉，页面不存在';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header('HTTP/1.1 405 Method Not Allowed');
                echo '抱歉，请使用 [' . $allowedMethods . '] 方法进行访问';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                try {
                    if (is_callable($handler)) {
                        $content = $handler($vars);
                    }
                    if (is_string($handler) && Str::contains($handler, '@')) {
                        $target = explode('@', $handler);
                        $controller = $target[0];
                        $method = $target[1];
                        $controller = new $controller;
                        $content = $controller->$method($vars);
                    }
                } catch (Exception $e) {
                    $content = Response::getInstance()->header('HTTP/1.1 500 Internal Server Error')
                        ->json([
                            'code' => 500,
                            'error_code' => $e->getCode(),
                            'message' => $e->getMessage(),
                        ]);
                }
                if ($content === 7031) {
                    break;
                }
                if (is_array($content)) {
                    return Response::getInstance()->json($content);
                }
                break;
        }
    }
}
