<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:21:16
 * Description: 常用几个魔术方法的使用
 */

class Test{
    public function __get($name) {
        return $name;
    }
    public function __set($name, $value) {
        return $name.'=>'.$value;
    }
    public function __call($name, $arguments) {
        return 'fun_name:'.$name.'  '. implode(',', $arguments);
    }
    public static function __callStatic($name, $arguments) {
        return 'static_fun_name:'.$name.'  '. implode(',', $arguments);;
    }
    /**
     * 对象当方法用的时候执行此方法
     */
    public function __invoke($params) {
        return $params;
    }
    public function __toString() {
        echo __CLASS__;
    }
}

$t = new Test();
echo $t('haha');