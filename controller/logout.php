<?php

// Controller for logout page:
class Logout
{
    public function __construct()
    {
        session_start();
        session_destroy();
        header("Location: /login.php");
        exit;
    }
}

new Logout();
