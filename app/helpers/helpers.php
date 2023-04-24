<?php

require_once __DIR__ . "/../../env.php";

/**
 * base URL project
 * @example http://localhost/library/
 */
const BASE_URL = "http://localhost/" . BASE_PATH . "/";

/**
 * get file from public/assets folder
 * @param ?string $path location
 * @example http://localhost/library/public/assets/$path
 */
function asset(?string $path = null): string
{
  return is_null($path) ? BASE_URL . "public/assets/" : BASE_URL . "public/assets/" . $path;
}

/**
 * path assets
 * @param ?string $path location
 * @example C:\xampp\htdocs\library\$path
 */
function path(?string $path = null): string
{
  return is_null($path) ? FULL_PATH . '/public/assets/' : FULL_PATH . "/public/assets/" . $path;
}

/** goto file */
function to_view(string $file)
{
  header("Location: " . BASE_URL . "view/" . $file . ".php");
  exit;
}

/** limit string, if string > $limit then add '...' */
function limit_word($str, $limit = 30)
{
  return (strlen($str) > $limit) ? substr($str, 0, $limit) . '...' : $str;
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

/** is logged to visitor/reader library */
function isLoggedToVisitor()
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

/** Helper debug like laravel */
function dump(...$value)
{
  echo "<pre>";
  print_r($value);
}

/** get data user logged */
function userAuth()
{
  $db = new Database();
  return $db->table('users')->where('id', '=', $_SESSION['auth_id'])->getOne();
}

function diffDays($firstDate, $secondDate)
{
  $firstDateTime = new DateTime($firstDate);
  $secondDateTime = new DateTime($secondDate);
  $interval = $secondDateTime->diff($firstDateTime);

  $daysDifference = $interval->format('%a');
  return $daysDifference;
}
