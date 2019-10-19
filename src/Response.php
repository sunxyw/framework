<?php

namespace Framework;

class Response
{
    private static $_instance = null;
    protected $content = '';
    protected $headers = [];

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

        $this->header('Content-type: application/json');
        $this->write(json_encode($data));
        $this->output();
    }

    public function write($content)
    {
        $this->content .= $content;
    }

    public function header($header)
    {
        $this->headers[] = $header;
    }

    public function output()
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->content;
    }
}
