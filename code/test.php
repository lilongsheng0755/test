<?php

require_once 'lib/ManagerMySql.php';
require_once 'lib/ADBDesign.php';
require_once 'lib/AReflectionClass.php';
require_once 'lib/SingleBase.php';
require_once 'lib/TableConstMap.php';
require_once 'lib/TableDesign.php';

$db_name = 'test';
$mysqli = new \mysqli('127.0.0.1', 'root', 'root');
$mysqli->set_charset("utf8mb4");

