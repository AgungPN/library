<?php

require_once __DIR__ . "/../../app/init.php";
$bookController = new Book();
$bookController->delete($_GET['book_id']);
