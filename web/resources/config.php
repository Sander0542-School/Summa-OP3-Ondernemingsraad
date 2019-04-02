<?php
session_start();

//require_once("composer/vendor/autoload.php");

define("RESOURCES_PATH", realpath(dirname(__FILE__)));
define("COMPOSER_PATH", realpath(dirname(__FILE__) . '/composer'));
define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
define("TEMPLATE_PATH", realpath(dirname(__FILE__) . '/template'));

require_once(COMPOSER_PATH . '/vendor/autoload.php'); //TODO() Create Classes

require_once(LIBRARY_PATH . '/autoload.php'); //TODO() Create Classes

$_CONNECTION = (new Connection())->getConnection();

$_GEBRUIKER = false;

if (Gebruiker::isIngelogd($_CONNECTION)) {
  $_GEBRUIKER = Gebruiker::fromID($_CONNECTION, $_SESSION["userID"]);
} else {
  if ($_SERVER["PHP_SELF"] != '/login.php') {
    header("Location: /login");
    die();
  }
}