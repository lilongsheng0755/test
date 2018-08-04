<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:34:45
 * Description: 单利模式演示,一般结合工厂模式一起用
 */

class Test{
    protected static $instance;
    private function __construct() {
       
    }
    static function getInstance(){
        if(self::$instance instanceof self){
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }
}

class Factory {

    static function createTest() {
        return Test::getInstance();
    }

}