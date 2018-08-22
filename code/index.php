<?php

/**
 * Author: skylong
 * CreateTime: 2018-6-21 21:43:31
 * Description: 
 */
//phpinfo();
$host = '192.168.0.102';
$username = 'test';
$passwd = 'test';
$dbname = 'test';
$port = 3306;
$mysqli = new mysqli($host, $username, $passwd, $dbname);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);

$mysqli->query("SELECT title FROM test");
$mysqli->commit();

$mysqli->close();