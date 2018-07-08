<?php

/**
 * Author: skylong
 * CreateTime: 2018-7-7 19:56:15
 * Description: 
 */
$a = php_ini_loaded_file();  //返回PHP配置文件的路径
$d = php_uname();   //返回当前Linux系统的版本，相当于Linux命令：uname -a
$e = phpversion();  //返回当前PHP版本
ini_set('session.gc_divisor', 'user');  //临时设置php.ini单个值
ini_get('session.gc_divisor');  //获取php.ini单个值
