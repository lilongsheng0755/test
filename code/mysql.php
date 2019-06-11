<?php

include_once './HelperBackupDB.php';
include_once './HelperException.php';
/**
 * Author: skylong
 * CreateTime: 2019-6-11 13:35:50
 * Description: 数据管理类
 */
$conn = new mysqli('192.168.3.182', 'root', 'root', 'test', 3306);
$conn->set_charset("utf8mb4");

try{
    HelperBackupDB::getInstance($conn)->doing();
}catch(HelperException $e){
    echo $e->getMessage();
}
die;

// 写入文件中        


// 以上结束数据备份
// 以下开始数据还原操作
$arr = file('备份数据库名.sql');

// 移除注释
function remove_comment($arr) {
    return (substr($arr, 0, 2) != '--');
}

$sql_str = array_filter($arr, 'remove_comment');
$sql_str = str_replace("\r", "", implode('', $sql_str));
$ret = explode(";\n", $sql_str);
foreach ($ret as $val) {
    $val = trim($val, " \r\n;");
    mysql_query($val, $link);
}