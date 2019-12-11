<?php

/**
 * Author: skylong
 * CreateTime: 2019-6-11 14:41:59
 * Description: 用于单例模式实例化基类
 */
abstract class SingleBase {

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
    public static function getInstance() {
        $key = md5(static::class);
        if (!isset(self::$instance[$key]) || !self::$instance[$key] instanceof static) {
            self::$instance[$key] = new static();
        }
        return self::$instance[$key];
    }

}
