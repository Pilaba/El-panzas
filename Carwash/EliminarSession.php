<?php
/**
 * Created by PhpStorm.
 * User: pilaba
 * Date: 22/04/2017
 * Time: 22:50
 */

function eliminarSession(){
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: Index.php");
}

eliminarSession();