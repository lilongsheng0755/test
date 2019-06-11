<?php

include_once './SingleBase.php';

/**
 * Author: skylong
 * CreateTime: 2019-6-11 14:18:17
 * Description: 数据备份辅助类
 */
class HelperBackupDB extends SingleBase {

    /**
     * mysqli对象
     *
     * @var mysqli
     */
    private $conn;

    /**
     * 备份类型：0 - 结构和数据，1 - 只备份数据
     *
     * @var int
     */
    private $backup_type = 0;

    /**
     * 记录备份的表
     *
     * @var array
     */
    private $backup_result = [];

    /**
     * 单例模式实例化
     * 
     * @param \mysqli $conn mysqli对象
     * @param int $backup_type 备份类型：0 - 结构和数据，1 - 只备份数据，2 - 只备份结构
     * @param string $select_db 当前备份数据库名
     * @return HelperBackupDB
     */
    public static function getInstance($conn, $backup_type = 0, $select_db = '') {
        return parent::getInstance($conn, $backup_type, $select_db);
    }

    /**
     * 初始化实例属性
     * 
     * @param \mysqli $conn mysqli对象
     * @param int $backup_type 备份类型：0 - 结构和数据，1 - 只备份数据
     * @param string $select_db 当前备份数据库名
     * @throws HelperException
     */
    public function __construct($conn, $backup_type = 0, $select_db = '') {
        if (!$conn instanceof \mysqli) {
            throw new HelperException('HelperBackupDB::__construct Missing mysqli objects', HelperException::E_PARAMS_CODE);
        }
        $this->conn = $conn;
        $select_db && $this->conn->select_db($select_db);
        in_array($backup_type, [0, 1, 2]) && $this->backup_type = $backup_type;
    }

    /**
     * 执行备份
     * 
     * @param string $export_dir 备份文件输出目录
     * @param string $export_sql_file 备份文件名【不用带后缀名】
     * @return boolean
     * @throws HelperException
     */
    public function doing($export_dir = './', $export_sql_file = '') {
        $export_sql_file = $export_sql_file ? rtrim($export_sql_file, '.sql') . '.sql' : date('Y-m-d_H-i-s', time()) . ".sql";
        $table_names = $this->getTablesName(); //获取当前库的所有表名
        if (!$table_names) {
            return false;
        }
        if (!$this->checkDir($export_dir)) {
            throw new HelperException('Failed to create directory ' . $export_dir, HelperException::E_MKDIR_CODE);
        }
        $export_path = $export_dir . $export_sql_file;
        return $this->writeSqlFile($table_names, $export_path);
    }

    /**
     * 获取备份结果
     * 
     * @return array
     */
    public function getBackupResult() {
        return $this->backup_result;
    }

    /**
     * 如果目录不存在则创建
     * 
     * @param string $dir
     * @return boolean
     */
    private function checkDir($dir) {
        if (!file_exists($dir) || !is_dir($dir)) {
            return mkdir($dir, 0744, true);
        }
        if (!is_writable($dir)) {
            return false;
        }
        return true;
    }

    /**
     * 获取当前库所有表名
     * 
     * @return array
     */
    private function getTablesName() {
        $sql = "SHOW TABLES";
        $tbl_name_arr = [];
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $tbl_name_arr[] = $row[0];
        }
        return $tbl_name_arr;
    }

    /**
     * 备份sql文件的头部信息
     * 
     * @param \mysqli $conn
     * @return string
     */
    private function getSqlFileHead() {
        $version = $this->conn->server_info;
        $sys_info['os'] = PHP_OS;
        $sys_info['php_ver'] = PHP_VERSION;
        $sys_info['date'] = date('Y-m-d H:i:s', time());
        $head = "-- skylong0031 SQL Dump Program" . PHP_EOL;
        $head .= "-- {$sys_info['os']}" . PHP_EOL;
        $head .= "-- PHP VERSION : {$sys_info['php_ver']}" . PHP_EOL;
        $head .= "-- MYSQL VERSION : {$version}" . PHP_EOL;
        $head .= "-- Date {$sys_info['date']}" . PHP_EOL;
        return $head;
    }

    /**
     * 处理sql语句的表字段
     * 
     * @param array $row 行数据
     * @return string
     */
    private function handleFields($row = []) {
        $fields = array_keys($row);
        $fields = implode('`,`', $fields);
        $fields = "`{$fields}`";
        return $fields;
    }

    /**
     * 处理sql语句的表值
     * 
     * @param array $row 行数据
     * @return string
     */
    private function handleValues($row = []) {
        $values = [];
        foreach ($row as $v) {
            $values[] = is_numeric($v) ? trim($v) : "'" . addslashes(trim($v)) . "'";
        }
        return implode(',', $values);
    }

    /**
     * 写入sql文件
     * 
     * @param array $tables 当前库的所有表名
     * @param array $filename 保存sql的文件名
     * @return boolean
     */
    private function writeSqlFile($tables = [], $filename = '') {
        if (file_exists($filename) && is_executable($filename)) {
            unlink($filename); //删除现有备份文件，实现二次备份
        }
        $flag = file_put_contents($filename, $this->getSqlFileHead());
        if ($flag === false || !$tables || !is_array($tables)) {
            return false;
        }
        $fh = fopen($filename, 'a');
        foreach ($tables as $table) {
            // 获取数据表定义
            if (!$this->backup_type) {
                $query = "SHOW CREATE TABLE {$table}";
                $result = $this->conn->query($query);
                if (!$result instanceof \mysqli_result) {
                    $this->backup_result['fail'][] = $table;
                    continue;
                }
                $row = $result->fetch_array(MYSQLI_NUM);
                $str = "{$row[1]};" . PHP_EOL;     // 数据表定义
                fwrite($fh, $str);
            }
            if ($this->backup_type != 2) {
                $str = '';
                $str .= "-- --------------------" . PHP_EOL;
                $str .= "-- Records of {$table}" . PHP_EOL;
                $str .= "-- --------------------" . PHP_EOL;

                // 获取数据表的数据
                $query = "SELECT * FROM {$table}";
                $result = $this->conn->query($query);
                if (!$result instanceof \mysqli_result) {
                    $this->backup_result['fail'][] = $table;
                    continue;
                }
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (!$row && !is_array($row)) {
                    continue;
                }
                $field = $this->handleFields($row);
                $values = $this->handleValues($row);
                $inser_fields = "INSERT INTO `{$table}` ({$field}) ";
                $inser_values = "VALUES" . PHP_EOL;
                $str .= $inser_fields . $inser_values;
                $end_values = "({$values});";
                fwrite($fh, $str);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $values = $this->handleValues($row);
                    $str = "({$values})," . PHP_EOL;
                    fwrite($fh, $str);
                }
                fwrite($fh, $end_values);
            }
            $this->backup_result['success'][] = $table;
        }
        return fclose($fh);
    }

}
