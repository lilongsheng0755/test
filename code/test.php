<?php

require_once 'lib/ManagerMySql.php';

$db_name = 'test';
$mysqli = new \mysqli('127.0.0.1', 'root', 'root');
$mysqli->set_charset("utf8mb4");
//$mysqli_result = $mysql->query('SHOW DATABASES');

echo '<pre>';
//while ($row = $mysqli_result->fetch_assoc()){
//    print_r($row);
//}
$tables = ManagerMySql::getIntance($mysqli)->dbIsExists($db_name)->allTableFromDB($db_name);
var_dump($tables);
