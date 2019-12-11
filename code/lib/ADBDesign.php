<?php

/**
 * Description of DbAdminCenter
 *
 * @author lilongsheng
 */
abstract class ADBDesign {

    /**
     * 数据库名称
     *
     * @var string
     */
    protected $db_name = 'admin_center';

    /**
     * 编码类型
     *
     * @var string
     */
    protected $charset = 'utf8mb4';

    /**
     * 编码校对
     *
     * @var string
     */
    protected $collate = 'utf8mb4_general_ci';

    /**
     * 数据表对象数组
     *
     * @var array
     */
    protected $object_tables = [];      

    /**
     * 子类需要继承创建表对象方法
     */
    abstract protected function createTableObject();

    /**
     * 添加表对象
     * 
     * @param TableDesign $table_obj
     * @return boolean|$this
     */
    protected function addTableObject($table_obj) {
        if (!$table_obj instanceof TableDesign) {
            return false;
        }
        $this->object_tables[] = $table_obj;
        return $this;
    }

    /**
     * 获取创建DB的sql语句
     * 
     * @return string
     */
    protected function getCreateDbSql() {
        return "CREATE DATABASE `{$this->db_name}` CHARACTER SET {$this->charset} COLLATE {$this->collate};";
    }

    /**
     * 获取当前数据库的表结构sql语句
     * 
     * @return string
     */
    protected function getCreateTableSql() {
        if (!$this->object_tables) {
            return '';
        }
        $sql = '';
        foreach ($this->object_tables as $table) {
            if (!$table instanceof TableDesign) {
                continue;
            }
            $table_name = $table->getTableName();
            $table_notes = $table->getTableNotes();
            $table_engine = $table->getTableEngine();
            $table_default_charset = $table->getTableDefaultCharset();
            $field_list = $table->getTableFieldAttrList();
            if (!$table_default_charset || !$table_engine || !$table_notes || !$table_name || !$field_list || !is_array($field_list)) {
                continue;
            }
            $sql .= "CREATE TABLE `{$table_name}` (" . PHP_EOL;

            // 拼接表字段属性
            foreach ($field_list as $field => $attr) {
                $sql .= "\t `{$field}` {$attr['field_type']}";
                $sql .= $attr['field_length'] !== '' ? "({$attr['field_length']})" : '';
                $sql .= $attr['is_unsigned'] === true ? '' : ' unsigned';
                $sql .= $attr['is_null'] === true ? ' NULL' : ' NOT NULL';
                $sql .= $attr['default_val'] !== null ? " DEFAULT {$attr['default_val']}" : '';
                $sql .= $attr['auto_increment'] === true ? ' AUTO_INCREMENT' : '';
                $sql .= $attr['comment'] !== '' ? " COMMENT '{$attr['comment']}'" : '';
                $sql .= ',' . PHP_EOL;
            }

            // 拼接主键属性
            $primary_key = $table->getPrimaryKey();
            if ($primary_key && is_array($primary_key)) {
                $sql .= "\t PRIMARY KEY (";
                foreach ($primary_key as $pk) {
                    $sql .= "`{$pk}`,";
                }
                $sql .= rtrim($sql, ',') . '),' . PHP_EOL;
            }

            // 拼接唯一键属性
            $unique_key = $table->getUniqueKey();
            if ($unique_key && is_array($unique_key)) {
                foreach ($unique_key as $k => $v) {
                    $sql .= "\t UNIQUE KEY `{$k}`(";
                    foreach ($v as $uk) {
                        $sql .= "`{$uk}`,";
                    }
                    $sql .= rtrim($sql, ',') . '),' . PHP_EOL;
                }
            }

            // 拼接索引键属性
            $index_key = $table->getIndexKey();
            if ($index_key && is_array($index_key)) {
                foreach ($index_key as $k => $v) {
                    $sql .= "\t KEY `{$k}`(";
                    foreach ($v as $ik) {
                        $sql .= "`{$ik}`,";
                    }
                    $sql .= rtrim($sql, ',') . '),' . PHP_EOL;
                }
            }
            $sql .= rtrim($sql, ',' . PHP_EOL) . "\t)" . PHP_EOL;

            // 拼接表属性
            $sql .= " ENGINE={$table_engine} DEFAULT CHARSET={$table_default_charset} COMMENT='{$table_notes}';" . PHP_EOL;
        }
        return $sql;
    }

}
