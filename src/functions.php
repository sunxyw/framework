<?php

use Framework\Framework;
use Framework\Response;

function config($name, $default = false)
{
    return Framework::getInstance()->getConfig($name, $default);
}

function response($content = false)
{
    if ($content) {
        return Response::getInstance()->write($content)->output();
    }

    return Response::getInstance();
}
