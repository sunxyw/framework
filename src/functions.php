<?php

use Framework\Framework;

function config($name, $default = false)
{
    return Framework::getInstance()->getConfig($name, $default);
}
