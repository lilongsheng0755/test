<?php

/**
 * Author: skylong
 * CreateTime: 2018-7-7 21:19:58
 * Description: 
 */
function unsetCookie($cookie) {
    setcookie($cookie, '', time() - 3600);
    unset($_COOKIE[$cookie]);
}
