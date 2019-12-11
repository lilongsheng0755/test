<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AReflectionClass
 *
 * @author lilongsheng
 */
abstract class AReflectionClass {

    /**
     * 单例实例化对象
     *
     * @var array
     */
    protected static $instance = [];

    /**
     * 单例模式实例化
     *
     * @return object
     */
    public static function getReflectionClass() {
        $key = md5(static::class);
        if (!isset(self::$instance[$key]) || !self::$instance[$key] instanceof ReflectionClass) {
            self::$instance[$key] = new ReflectionClass(static::class);
        }
        return self::$instance[$key];
    }

}
