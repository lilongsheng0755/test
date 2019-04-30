<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 18:25:46
 * Description: 迭代器模式：迭代器模式，在不需要了解内部实现的前提下，遍历一个聚合对象的内部元素
 */
class AllUser implements Iterator {

    protected $ids;
    protected $index;
    protected $data = array();

    function __construct() {
        /**
         * 从数据库中读取所有用户ID
         */
    }

    public function current() {
        $id = $this->ids[$this->index]['id'];
        return Factory::getUser($id);
    }

    public function key()  {
        return $this->index;
    }

    public function next()  {
        return $this->index++;
    }

    public function rewind() {  //重置
        $this->index = 0;
    }

    public function valid() {
        return $this->index < count($this->ids);
    }

}

$users = new AllUser();
foreach ($users as $user) {
    var_dump($user);
}

