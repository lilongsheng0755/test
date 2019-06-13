<?php

include_once './lib/SingleBase.php';
include_once './helper/HelperBackupDB.php';
/**
 * Author: skylong
 * CreateTime: 2019-6-11 13:35:50
 * Description: 数据管理类
 */
$conn = new \mysqli('192.168.3.182', 'root', 'root', 'test', 3306);
$conn->set_charset("utf8mb4");

try{
    HelperBackupDB::getInstance($conn)->doing();
}catch(HelperException $e){
    echo $e->getMessage();
}
die;
