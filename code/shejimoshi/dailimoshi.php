<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 18:41:24
 * Description: 代理模式，有利于业务代码分离，例如：数据库的读写分离
 */
class Proxy implements IUserProxy {

    public function getUserName($id) {
        $db = Factory::getDatabase('slave');
        $db->query("select name from user where id={$id} limit 1");
    }

    public function setUserName($id, $name) {
         $db = Factory::getDatabase('master');
         $db->query("update user set name='{$name}' where id={$id} limit 1");
    }

}

interface IUserProxy {

    function getUserName($id);

    function setUserName($id, $name);
}

$proxy = new Proxy();
$proxy->getUserName($id);
$proxy->setUserName($id,$proxy);