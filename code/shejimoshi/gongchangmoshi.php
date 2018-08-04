<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 16:31:18
 * Description: 工厂模式演示
 */
class Test {
    
}

class Factory {

    static function createTest() {
        $t = new Test();
        return $t;
    }

}
