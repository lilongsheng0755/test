<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:40:46
 * Description: 注册树模式,结合工厂模式,一般在项目初始化或业务开始之前注册好
 */
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

class Test {

    protected static $instance;

    private function __construct() {
        
    }

    static function getInstance() {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }

}

class Factory {

    static function createTest() {
        $t = Test::getInstance();
        Register::set('t', $t);
        return $t;
    }
}
Register::get('t');