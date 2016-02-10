<?php

/**
 * Error page controller
 */
class Error
{
    public function __construct()
    {
        header("HTTP/1.0 404 Not Found");
        echo '404';
        exit;
    }
}
