<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 17:19:36
 * Description: 数据对象映射模式(表数据映射成一个对象)
 */
class User{
    private static $instance;
    public $id;
    public $name;
    public $mobile;
    public $regtime;
    private function __construct($id) {
        /**
         * 查询数据，把数据映射到类属性
         */
    }
    
    static function getUser($id){
        $key = 'user'.$id;
        $user = Register::get($key);
        if(!$user){
            $user = new self($id);
            Register::set($key, $user);
        }
        return $user;
    }
            
    function __destruct() {
        /**
         * 更新数据到数据表
         */
    }
}

class Register {

    protected static $objects;

    static function get($alias){
        return self::$objects[$alias]; 
    }
    static function set($alias, $object) {
        self::$objects[$alias] = $object;
    }
    

    static function __unset($alias) {
        unset(self::$objects[$alias]);
    }
}

class Factory {

    static function createTest() {
        $t = Test::getInstance();
        Register::set('t', $t);
        return $t;
    }
}
$user = new User(1);
$user->mobile = '151555156464';
$user->name = '哈哈';
$user->regtime = time();
