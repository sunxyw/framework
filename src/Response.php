<?php

namespace Framework;

class Response
{
    private static $_instance = null;

    private function __construct()
    {
        //
    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function json($data)
    {
        if (!isset($data['code'])) {
            $data['code'] = 200;
        }
        if (!isset($data['message'])) {
            $data['message'] = 'OK';
        }

        return $this->write(json_encode($data));
    }

    public function write($content)
    {
        echo $content;
    }
}
