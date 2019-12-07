<?php

/**
 * Description of DbAdminCenter
 *
 * @author lilongsheng
 */
abstract class ADbStructure {

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

    protected function addTableObject($table_obj) {
        
    }

}
