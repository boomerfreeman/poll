<?php

// Controller for admin panel:
class AdminPanel
{
    public function __construct()
    {
        require_once 'view/header.php';
        require_once 'view/adminpanel.php';
        require_once 'view/footer.php';
    }
}