<?php

require_once __DIR__ . "/../../app/init.php";

$userService = new User();
$userService->delete($_GET['user_id'] ?? 0);
