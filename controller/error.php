<?php

/**
 * Error page controller
 */
class Error
{
    public function __construct()
    {
        header("HTTP/1.0 404 Not Found");
        echo 'Error #404';
        exit;
    }
}
