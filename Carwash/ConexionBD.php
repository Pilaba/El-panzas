<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 17/03/2017
 * Time: 01:38 AM
 */
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'carwashBD';

$dbConn = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_set_charset('utf8');
mysql_select_db($dbName,$dbConn);