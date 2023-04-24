<?php
// set session_start
if(!session_id()) session_start();

/** autoload application */
spl_autoload_register(function ($class) {
  $class = explode("\\", $class);
  $class = end($class);

  if (file_exists($f = __DIR__ . "/helpers/" . $class . ".php"))
    require_once $f;

  if (file_exists($f = __DIR__ . "/core/" . $class . ".php"))
    require_once $f;

  if (file_exists($f = __DIR__ . "/controllers/" . $class . ".php"))
    require_once $f;

});
require_once __DIR__ . "/helpers/helpers.php";
