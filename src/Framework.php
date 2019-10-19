<?php

namespace Framework;

use Noodlehaus\Config;

class Framework
{
    private static $_instance = null;
    private $router;
    private $core;
    protected $config;

    private function __construct()
    {
        $this->router = new Router;
        $this->core = new Core;
    }

    public function init($config)
    {
        $this->config = new Config($config);
        session_start();
    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function getConfig($name, $default = false)
    {
        $config = $this->config;
        return $config->get($name, $default);
    }

    public function run()
    {
        $this->core->setReporting();
        $dispatcher = $this->router->build();
        $this->core->route($dispatcher);
    }
}
