<?php

use Framework\Framework;
use Framework\Response;

function config($name, $default = false)
{
    return Framework::getInstance()->getConfig($name, $default);
}

function response()
{
    return Response::getInstance();
}
