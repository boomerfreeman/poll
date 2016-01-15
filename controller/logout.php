<?php

class Logout
{
    public function __construct()
    {
        session_start();
        session_destroy();
        header("Location: ../index.php");
        exit;
    }
}

new Logout();
