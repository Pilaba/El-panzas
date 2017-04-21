<?php

STATIC $dbHost = 'localhost';
STATIC $dbUser = 'root';
STATIC $dbPass = '';
STATIC $dbName = 'carwashBD';

/* Se utilizara el modo orientado a objetos por sobre el procedural  http://php.net/manual/es/book.mysqli.php */

$Mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName);
$Mysqli->set_charset("utf8");

if ($Mysqli->connect_error) die($Mysqli->connect_error);/* comprobacion si existe error */

