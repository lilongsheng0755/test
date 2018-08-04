<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:16:15
 * Description: 链式操作的演示
 */
class db {

    public function select() {
        return $this;
    }

    public function where() {
        return $this;
    }

    public function limit() {
        return $this;
    }

}

$db   = new db();
$data = $db->where('id=1')->where('type=2')->limit(10)->select();
