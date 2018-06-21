<?php

/**
 * Author: skylong
 * CreateTime: 2018-6-20 14:07:22
 * Description: 
 */
$mysqli = new mysqli('127.0.0.1', 'test', 'test', 'test');

/* ----------------模拟数据写入数据表--------------------- */
$setNum = 1000000; //设置插入数据行数
$ctime = time();
$mc = microtime(true);
for ($i = 1; $i <= $setNum; $i++) {
    $sql = "INSERT INTO `baseinfo` SET `uid`={$i}, `realname`='user_{$i}', `idcard`='44092114566{$i}', `nickname`='user_{$i}',";
    $sql .= "`icon`='http://192.168.1.111:81/dokuwiki/lib/tpl/dokuwiki/images/apple-touch-icon.png', `phone`='14718052215',`area`='中国', `register`={$ctime}, `lastlogin`={$ctime}";
    $mysqli->query($sql);
}

echo microtime(true)-$mc;

$mysqli->close();

