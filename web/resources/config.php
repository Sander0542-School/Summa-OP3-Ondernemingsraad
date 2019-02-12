<?php
session_start();

//require_once("composer/vendor/autoload.php");

define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
define("TEMPLATE_PATH", realpath(dirname(__FILE__) . '/template'));

require_once(LIBRARY_PATH . '/autoload.php'); //TODO() Create Classes

$_CONNECTION = (new Connection())->getConnection();