<?php

define(ROOT, dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

// error_reporting(E_ALL);
// ini_set('display_errors', 'on');

session_start();

$router = new Router();
$router->run();