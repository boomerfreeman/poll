<?php

// Controller for poll page:
class Poll
{
    public function __construct()
    {
        require_once 'view/header.php';
        require_once 'view/poll.php';
        require_once 'view/footer.php';
    }
}