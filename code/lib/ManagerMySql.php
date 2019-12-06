<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySqlManager
 *
 * @author lilongsheng
 */
class ManagerMySql {
    // 创建数据库：CREATE DATABASE `test` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

    /**
     * ManagerMySql实例
     * 
     * @var ManagerMySql 
     */
    private static $instance = null;

    /**
     * mysqli实例
     * 
     * @var \mysqli
     */
    private $mysqli = null;

    /**
     * 数据库差异【保存不存在的库名】
     *
     * @var array
     */
    private $diff_db = [];

    /**
     * 数据表差异【保存不存在的表名】
     *
     * @var array
     */
    private $diff_table = [];

    /**
     * 单利模式实例化
     * 
     * @param \mysqli $mysqli
     * @return ManagerMySql
     */
    public static function getIntance($mysqli, $db_name = '') {
        if (!self::$instance instanceof self) {
            self::$instance = new self($mysqli, $db_name);
        }
        return self::$instance;
    }

    /**
     * 初始化检测是否为有效mysqli
     * 
     * @param \mysqli $mysqli mysqli实例
     * @param string $db_name 数据库名称
     * @return \mysqli
     */
    private function __construct($mysqli, $db_name = '') {
        if (!$mysqli instanceof \mysqli) {
            die('not found obj from mysqli!'); // 输出到控制台
        }

        $this->mysqli = $mysqli;

        if (!$db_name = trim($db_name)) {
            die('db name is not empty!'); // 输出到控制台
        }

        $mysqli_result = $this->mysqli->query('SHOW DATABASES');
        $flag = false;
        while ($row = $mysqli_result->fetch_assoc()) {
            if ($row['Database'] == $db_name) {
                $flag = true;
                break;
            }
        }
        if (!$flag) {
            die("Database `{$db_name}` does not exist!"); // 输出到控制台
        }

        $this->mysqli->select_db($db_name);
        return $this->mysqli;
    }

    /**
     * 数据表是否存在
     * 
     * @param string $tbl_name 表名称
     * @return boolean
     */
    public function tableIsExists($tbl_name) {
        if (!$tbl_name = trim($tbl_name)) {
            die('table name is not empty!'); // 输出到控制台
        }

        $mysqli_result = $this->mysqli->query('SHOW TABLES');
        $flag = false;
        while ($row = $mysqli_result->fetch_assoc()) {
            if ($row['Tables_in_test'] == $tbl_name) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

}
