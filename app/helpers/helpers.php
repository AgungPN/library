<?php

require_once __DIR__ . "/../../env.php";

define("BASE_URL", "http://localhost/" . BASE_PATH . "/");
/**
 * get file from asset
 * @param ?string $path location
 */
function asset(?string $path = null): string
{
  return is_null($path) ? BASE_URL . "/public/assets/" : BASE_URL . "/public/assets/" . $path;
}

/**
 * path assets
 * @param ?string $path location
 */
function path(?string $path = null): string
{
  return is_null($path) ? getcwd() . '/assets/' : getcwd() . "/assets/" . $path;
}

function to_view(string $file)
{
  header("Location: " . BASE_URL . "view/" . $file . ".php");
  exit;
}

function isLoggedToAdmin()
{
  // if found  $_SESSION['auth_id'] means already login
  if (isset($_SESSION['auth_id'])) {
    // if is_admin true, then return true
    if (isset($_SESSION['is_admin']) and $_SESSION['is_admin'] === true) {
      return true;
    }
  }
  return false;
}

function isLoggedToReader()
{
  if (isset($_SESSION['auth_id'])) {
    // if is_admin false, then return true
    if (isset($_SESSION['is_admin']) and $_SESSION['is_admin'] === false) {
      return true;
    }
  }
  return false;
}

/** Helper debug like laravel */
function dd(...$value)
{
  echo "<pre>";
  print_r($value);
  die;
}
