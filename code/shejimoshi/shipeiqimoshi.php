<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:50:23
 * Description: 适配器模式,随意切换实例，方法名和属性名约定于接口
 */
class MySql implements IDatabase{
    
    public function close() {
        
    }

    public function connect() {
        
    }

    public function query() {
        
    }

}
class MySqli implements IDatabase{
    
    public function close() {
        
    }

    public function connect() {
        
    }

    public function query() {
        
    }

}
class PDO implements IDatabase{
    
    public function close() {
        
    }

    public function connect() {
        
    }

    public function query() {
        
    }

}

interface IDatabase{
    function connect();
    function query();
    function close();
}
$db = new MySql();//实例随意切换
$db->connect();
$db->query();
$db->close();