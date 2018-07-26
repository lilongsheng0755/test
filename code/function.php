<?php

/**
 * Author: skylong
 * CreateTime: 2018-7-7 21:19:58
 * Description: 
 */
function clearCookie($cookie) {
    setcookie($cookie, '', time() - 3600,'/');
}

function clearSession($session_key) {
    //第一步
    session_start();
    //第二步
    $_SESSION = array();
    //第三步
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600,'/');
    }
    //第四步
    session_destroy();
}
