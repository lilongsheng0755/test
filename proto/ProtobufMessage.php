<?php

defined('IN_APP') or die('Access denied!');

/**
 * Author: skylong
 * CreateTime: 2018-10-23 0:01:06
 * Description: 使用ReflectionClass::export导出的ProtobufMessage类
 */
abstract class ProtobufMessage {

    const PB_TYPE_DOUBLE     = 1;
    const PB_TYPE_FIXED32    = 2;
    const PB_TYPE_FIXED64    = 3;
    const PB_TYPE_FLOAT      = 4;
    const PB_TYPE_INT        = 5;
    const PB_TYPE_SIGNED_INT = 6;
    const PB_TYPE_STRING     = 7;
    const PB_TYPE_BOOL       = 8;

    public function __construct();

    abstract public function reset();

    public function append($position, $value);

    public function clear($position);

    public function dump($onlySet, $level);

    public function count($position);

    public function get($position);

    public function parseFromString($packed);

    public function serializeToString();

    public function set($position, $value);

    public function printDebugString($level);
}
