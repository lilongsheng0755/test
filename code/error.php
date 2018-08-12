<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-11 12:04:24
 * Description: 自定义错误处理
 */
error_reporting(0);

function error_handler($error_level, $error_message, $file, $line) {
    $exit = false;
    switch ($error_level) {
        //提醒级别
        case E_NOTICE:
        case E_USER_NOTICE:
            $error_type = 'Notice';
            break;

        //警告级别
        case E_WARNING:
        case E_USER_WARNING:
            $error_type = 'Warning';
            break;

        //错误级别
        case E_ERROR:
        case E_USER_ERROR:
            $error_type = 'Fatal Error';
            $exit       = true;
            break;

        //其他未知错误
        default :
            $error_type = 'Unknown';
            $exit       = true;
    }
    
    //直接打印错误信息，也可以写文件，写数据库
    printf("<font color='red'><b>%s</b></font>: %s in <b>%s</b> on line <b>%d</b><br>".PHP_EOL, $error_message,$file,$line);
    if($exit){
        echo '<script>location="err.html";</script>';
    }
    
    //把错误交给自定义错误处理函数，error_reporting()将会失效
    set_error_handler('error_handler');
    
    //报notice
    echo $novar;
    
    //自定义一个错误
    trigger_error('Trigger a fatal error', E_USER_ERROR);
}
