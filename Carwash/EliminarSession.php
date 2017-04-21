<?php
/**
 * Created by PhpStorm.
 * User: pilaba
 * Date: 21/04/2017
 * Time: 15:27
 */
function DestroySession(){
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: Index.php");
}

DestroySession();